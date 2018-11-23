#!/bin/sh

echo "> Create app/logs"
mkdir app/logs
chmod 777 app/logs

echo "> Define permission for app/db"
chmod -R 777 app/db

echo "> Create src/view/templates/compiles"
mkdir src/view/templates/compiled
chmod 777 src/view/templates/compiled

echo "> Create src/assets/css"
mkdir web/assets/css

echo "> Create src/assets/js"
mkdir web/assets/js

echo "> Install composer packages"
composer install

echo "> Install bfw modules"
./vendor/bin/bfwInstallModules

echo "> Install npm packages"
npm install

echo "> Execute gulp"
./node_modules/.bin/gulp
