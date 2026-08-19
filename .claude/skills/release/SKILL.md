---
name: release
description: Arkheのアップデートをリリースする。lint・ビルド・zip作成・バージョンコミット・pushまでを行う。WordPress.orgへのzipアップロードは手動。
user-invocable: true
---

# Arkhe Release Skill

Arkhe テーマのアップデートをリリースする。lint からバージョンコミットの push までを実行し、**WordPress.org へのアップロードはユーザーが手動で行う**。

このリポジトリには CI もリリースワークフローも無く、Git タグ運用も 3.2.2 で止まっている。**タグは打たない。**

## 前提

- 作業ブランチは `master`。`master` の内容がそのままリリース対象になる
- `dist/` は `.gitignore` 対象でコミットされないが、**zip には含める必要がある**。そのため必ず ビルド → zip の順で実行する
- ビルドは `.node-version`（現在 22）の node を使う。パッケージ操作・スクリプト実行は `@antfu/ni` 系コマンドを使う
- `readme.txt` の Changelog は GitHub へのリンクのみなので、リリース時に変更履歴を書き足す必要はない

## 実行フロー

### 1. リリースバージョンを確定する

引数からバージョン番号を取得する。

- 受け付ける形式: `3.14.0`, `3-14-0`, `--version=3.14.0`
- **ドット区切り（`3.14.0`）を推奨する。** `bin/zip.sh` は zip のファイル名に引数をそのまま使うため、`3-14-0` を渡すと `arkhe-3-14-0.zip` になる（ファイル内のバージョン表記はドットに変換されるので中身は正しい）
- 引数が無い場合は、現在のバージョンを提示した上でユーザーに確認する

```bash
grep -i "^Version" style.css
grep -i "Stable tag" readme.txt
```

- 現在のバージョン以下の番号が指定された場合は、指摘した上で確認を取る

### 2. 事前チェック

以下を確認し、問題があれば**勝手に解決せず報告して止まる**。

```bash
git branch --show-current
git status --porcelain
```

- ブランチが `master` でなければ止まる
- 未コミット・未ステージの変更が残っていれば、その一覧を提示して「リリースに含めるのか」をユーザーに確認する。勝手に stash・コミット・破棄はしない
- `vendor/` が無ければ `composer install`、`node_modules/` が無ければ `ni` を実行する

### 3. lint

```bash
nr lint:php
nr lint:css
```

- どちらかが失敗したら、エラー内容を報告して**そこで止まる**。`lint:php:fix` / `lint:css:fix` を自己判断で実行しない
- 実行は `runner` サブエージェントに任せてよい（出力が長いため、成否とエラーの要点だけ持ち帰らせる）

### 4. ビルド

```bash
nr build
```

- CSS（`sass-builder.js`）と JS（webpack, front/admin/guten）の両方が走る
- 失敗したら報告して止まる
- ビルド後、`dist/` が生成されていることを確認する

### 5. zip を作成する

先に 1 つ上の階層に `arkhe.zip` が残っていないか確認する。`bin/zip.sh` は `zip -r arkhe.zip arkhe` で作るため、中断などで前回の `arkhe.zip` が残っていると中身が混ざる。

```bash
ls -1 ../arkhe.zip 2>/dev/null
```

残っていた場合は、削除してよいかユーザーに確認してから進む（バージョン名付きの `arkhe-*.zip` は過去のリリース成果物なので消さない）。

```bash
nr update {version}
```

`bin/zip.sh` がやること:

- `style.css` の `Version:` を書き換え
- `readme.txt` の `Stable tag:` を書き換え
- `.DS_Store` を削除
- 1 つ上の階層に `arkhe-{引数}.zip` を出力（`node_modules` / `vendor` / 開発設定ファイルなどを除外）

### 6. zip の中身を検証する

```bash
unzip -l ../arkhe-{version}.zip | head -40
unzip -l ../arkhe-{version}.zip | grep -E "node_modules|vendor/|DS_Store|CLAUDE\.md|AGENTS\.md|package(-lock)?\.json|composer\.(json|lock)|phpcs\.xml|webpack\.config|arkhe/\."
```

2 つ目のコマンドは**何もヒットしないのが正常**。1 行でも出力されたら混入しているということなので確認する。

- **含まれているべきもの**: `arkhe/dist/`、`arkhe/style.css`、`arkhe/readme.txt`、テンプレート・`inc/`・`classes/` 等の PHP
- **含まれていてはいけないもの**: `node_modules`、`vendor`、`.DS_Store`、ドットファイル、`CLAUDE.md`、`AGENTS.md`、`package.json`、`composer.json`、`phpcs.xml`、`webpack.config.js`
- zip 内の `style.css` のバージョンが指定どおりか確認する

```bash
unzip -p ../arkhe-{version}.zip arkhe/style.css | grep -i "^Version"
```

- 想定外のものが混入していたら、削除や再パッケージを自己判断でせず、状況を報告して確認を取る

### 7. バージョン差分をコミットして push する

`nr update` で書き換わるのは `style.css` と `readme.txt` の 2 ファイルだけ。差分がこの 2 ファイルに収まっているかを必ず確認する。

```bash
git status --porcelain
git diff
```

- 2 ファイル以外に差分がある場合は止まって報告する
- コミットメッセージは**バージョン番号のみ**（過去の慣習: `3.13.0`）。`v` は付けない

```bash
git add style.css readme.txt
git commit -m "{version}"
git push
```

- **タグは打たない**

### 8. 報告する

次を簡潔に報告し、最後の手動作業を案内する。

- リリースバージョン
- lint / ビルドの結果
- 出力した zip の絶対パスとファイルサイズ
- コミットハッシュと push 先

続いてユーザーが手動で行うこと:

1. https://ja.wordpress.org/themes/upload/ に `arkhe-{version}.zip` をアップロードして公開

## 注意事項

- **Git タグは打たない。** タグ運用は 3.2.2 で終了しており、それ以降のリリースにタグは無い
- `readme.txt` の `Tested up to:` は `bin/zip.sh` の対象外。WordPress 本体の新バージョンに合わせて更新する必要があるかは、リリース前にユーザーへ確認する
- lint やビルドが失敗したときに、自己判断で `:fix` 系コマンドを走らせたりコードを修正したりしない。報告して指示を待つ
- `dist/` は直接編集しない。修正は `src/` を直してビルドし直す
- 手順 5 以降で中断・中止する場合、`style.css` と `readme.txt` にバージョン書き換えだけが残る。リリースを取りやめるなら `git checkout -- style.css readme.txt` で戻す（実行前にユーザーへ確認する）
- 同じコマンドで 3 回続けて失敗したら、リトライを止めて状況を報告する
- 日本語の本文では英数字と日本語の間に半角スペースを入れない
