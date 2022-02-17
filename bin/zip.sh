#!/bin/bash

# to use: bash ./bin/zip.sh 1-6-2

version=$1
version=${version//-/.}

# style.css のバージョン書き換え
sed -i '' -e "s/Version: .*/Version: ${version}/g" style.css;

# readme.txt のバージョン書き換え
sed -i '' -e "s/Stable tag: .*/Stable tag: ${version}/g" readme.txt;

# DS_Store削除
find . -name '.DS_Store' -type f -ls -delete

#上の階層へ
cd ../

# 不要なファイルを除いてzip化
zip -r arkhe.zip arkhe -x "*/.*" "*/__*" "*bin*" "*node_modules*" "*vendor*" "*package.json" "*package-lock.json" "*composer.json" "*composer.lock" "*postcss.config.js" "*webpack.config*"

# zipから不要なファイルを削除
zip --delete arkhe.zip  "arkhe/.*" "arkhe/README.md" "arkhe/phpcs.xml"

mv arkhe.zip arkhe-${1}.zip
