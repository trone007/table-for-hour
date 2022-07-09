#!/bin/bash

cd /home/bitrix/table-for-hour/

git pull

yarn install
yarn build

php bin/console --no-interaction doctrine:migrations:migrate
