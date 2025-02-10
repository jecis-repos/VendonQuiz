#!/bin/sh
# shellcheck disable=SC2164
cd "${0%/*}"
cd ../../ || exit
docker compose exec database fish -c "mysqldump -h localhost -u root -pvendon vendon | gzip -cf | gunzip -c > vendon.sql"
