# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 概要

WordPress テーマ「Arkhe」（開発元: LOOS,Inc.）の開発リポジトリ。WordPress.org 公式ディレクトリに掲載されている無料テーマで、ブロックエディター対応のシンプルなベーステーマ。
動作要件は WordPress 6.0 以上 / PHP 7.0 以上（`style.css`・`readme.txt`）。
拡張版（Arkhe Pro 等）向けのライセンス認証・アップデート機構を内蔵する。

## リポジトリ運用

- 開発・リリースとも **`master`** で行う。`master` がそのまま WordPress.org に公開される。`develop` ブランチは master より大きく遅れた放置ブランチなので使わない。
- Issue 修正は専用ブランチを切り、`master` 向けの PR にする（コミットメッセージに `#番号` で Issue を参照する慣習）。
- WordPress の仕様を調べるとき・コードを実装するときは、推測で進めず **WordPress MCP（`wp-handbook`）で公式ドキュメントを参照する**。テーマ実装は Theme Handbook / Block Editor Handbook、関数・フックは APIs Handbook、コーディング規約は WPCS Handbook を確認する。公式ディレクトリ掲載テーマのため、エスケープ・サニタイズ・i18n の規約遵守が必須。
- 「SWELL を参考にして」と指示されたら、WordPress テーマ「SWELL」のリポジトリ **`/Users/ryo/DEV/Themes/SWELL/swell`** を参照する（実装パターンや構成の参考用。Arkhe へコードをそのまま流用しない）。

## 開発コマンド

ビルドツールは `node` 16 系を前提（`.node-version`）。パッケージ操作は `@antfu/ni` 系コマンドを使う。

```bash
npm install              # JS 依存をインストール
composer install         # phpcs（WPCS 3.x）をセットアップ

npm run build            # 全ビルド（build:js + build:css）
npm run build:css        # CSS のみ（sass-builder.js）
npm run build:js         # JS のみ（front + admin + guten）

npm run watch:css        # src/**/*.scss を監視して再ビルド
npm run watch:js         # src/js/**/*.js を監視して再ビルド

composer phpcs           # PHP の lint（コミット前に通す）
```

`npm run wp-start` / `wp-stop` で `wp-env` のローカル環境を起動・停止できる。PHP/JS とも自動テストは無い。

リリース zip は `npm run update`（`bin/zip.sh`）。引数にバージョンを渡すと `style.css`・`readme.txt` のバージョンを書き換え、`node_modules`・`vendor`・開発設定ファイルを除外して 1 つ上の階層に `arkhe-{version}.zip` を出力する。

## ビルドの仕組み（重要）

ソース（`src/`）とビルド成果物（`dist/`）が分離している。**`dist/` は `.gitignore` 対象でコミットされず、直接編集もしない**こと。ビルド系統は CSS と JS の 2 つ。

- **CSS**: webpack ではなく独自スクリプト `sass-builder.js`（node-sass + postcss / autoprefixer / css-mqpacker / cssnano）が `src/scss/` を `dist/css/` へコンパイル。**ビルド対象は `sass-builder.js` 内の `files` 配列**で固定管理（glob ではない）。新しいトップレベル CSS を増やすときはこの配列に追記する。
- **JS**: `webpack.config.js`（`@wordpress/scripts` のデフォルト設定を継承）。環境変数 `TYPE`（`front` / `admin` / `guten`）で対象を切り替え、エントリ一覧は `webpack.config.js` 内に `TYPE` ごとに定義。**新しい JS エントリを追加するときはこの配列にも登録が必要**。`guten` ビルドのみ依存抽出した `*.asset.php` を出力し、front/admin は出力しない。

## アーキテクチャ

### 起動フロー

`functions.php` がエントリポイント。`Arkhe` クラス（`\Arkhe_Theme\Data` を継承し `Utility\*` trait を use）を `new` し、コンストラクタ内で `inc/*.php` を順に require する。機能を追加するときは対応する `inc/` ファイルに合流させる。

### オートロード

`functions.php` 内の `spl_autoload_register` で実装。クラス名に `Arkhe_Theme` を含む場合のみ `classes/` 配下にマップする（`Arkhe_Theme/` プレフィックスを除去し、名前空間の `\` をディレクトリ区切りに変換）。例: `\Arkhe_Theme\Utility\Get` → `classes/Utility/Get.php`。

### 中心クラス

- **グローバルクラスは `Arkhe`**（名前空間なし、`functions.php` で定義）。テンプレート・パーツから呼ぶ中心 API。`Data` を継承して設定取得を担い、`Utility/` 配下の trait（`Attrs` / `Get` / `SVG` / `Image` / `Parts` / `Output` / `Licence` / `Condition`）でメソッドを分割している。
- それ以外の内部クラスは `\Arkhe_Theme\` 名前空間（`classes/` 配下）。

### 設定データ

カスタマイザーの設定は WordPress option **`arkhe_settings`** に集約（`Data::DB_NAMES`）。`Data::set_settings_data()` が `after_setup_theme` でデフォルト値と DB 値をマージする。

- 取得は `Arkhe::get_setting( $key )`、デフォルトは `Arkhe::get_default_setting( $key )`。
- **デフォルト値の定義は `classes/Data/Default_Data.php` の `get_default_settings()`**。設定項目を増やすときはここに追加する。
- ライセンスキーは別 option `arkhe_licence_key`。

カスタマイザーの登録は `inc/customizer.php` + `inc/customizer/*.php`（セクションごとに分割）、コントロールクラスは `classes/Customizer/`。

### 動的 CSS（Style クラス）

`classes/Style.php` がカスタマイザー設定から CSS 変数・スタイルを生成し、`Arkhe::output_style( 'front' | 'editor' )` 経由で `wp_add_inline_style` によりインライン出力する。`add_root_css` / `add_css` でデバイス別（`all` / `pc` / `sp` / `tab` / `mobile`）に振り分け、メディアクエリ付きで連結する。CSS 変数は `--ark-*` 接頭辞。

### テンプレートとパーツ

- ルート直下の `single.php` / `archive.php` / `page.php` 等が WordPress テンプレート階層。
- `templates/` はページテンプレート（`one-column` 等）。
- 再利用パーシャルは `template-parts/`。`Arkhe::get_part( $slug, $args )` で読み込み、**子テーマ → 親テーマの順**で探索する。`arkhe_pre_get_part__{slug}` / `arkhe_part_args__{slug}` / `arkhe_part_path__{slug}` / `arkhe_part_cache__{slug}` / `arkhe_did_get_part__{slug}` のフックで差し替え・キャッシュ可能。
- `inc/pluggable.php` は `if ( ! function_exists() )` でラップした上書き可能関数（子テーマで差し替え可能）。

### Gutenberg

ブロック本体は別プラグイン「Arkhe Blocks」側にあり、テーマには含まれない。テーマ側の `inc/gutenberg.php` は `render_block_*` フィルタによる出力調整のみ。ブロック関連の `add_theme_support` は `inc/theme_support.php`。エディター用 JS は `src/js/gutenberg/post_editor.js`（`TYPE=guten` でビルド）。

### モジュール CSS

`classes/Style/__Module.php` の `Module` trait が `dist/css/module/` の CSS を必要時のみ読み込む。`get_module_path()` は子テーマ → 親テーマの順で探索。overlay-header / luminous など条件付きの CSS/JS は `inc/enqueue_scripts.php` で個別に判定して enqueue する。


## コーディング規約

- PHP は `phpcs.xml`（WordPress Theme Coding Standards + PHPCompatibility、WPCS 3.x ベース）に従う。コミット前に `composer phpcs` を通す。
- 既存コードはタブインデント、コメントは日本語が基本。周辺コードのスタイルに合わせる。テキストドメインは `arkhe`。
- SCSS は FLOCSS 的構成（`foundation` / `layout` / `object`）。クラス接頭辞は `l-`（layout）/ `c-`（component）/ `p-`（project）/ `u-`（utility）。

## リリース手順
1. lintチェック: lint:php, lint:css
2. ビルド: nr build
3. zip化: nr update {version} (例: nr update 3-12-1)
  - bin/zip.sh がやること:
  - 引数の - を . に変換（3-12-1 → 3.12.1）
  - style.css の Version: を書き換え
  - readme.txt の Stable tag: を書き換え
  - .DS_Store を削除
  - 1 つ上の階層へ移動し arkhe-{引数}.zip を出力（※ファイル名は引数そのまま。3-12-1 指定なら arkhe-3-12-1.zip）
4. バージョン書き換え分をコミット (style.css と readme.txt の差分が出るので master にコミット)
5. https://ja.wordpress.org/themes/upload/ に zipアップロードして公開
