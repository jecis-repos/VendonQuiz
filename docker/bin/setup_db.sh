#!/bin/sh
# shellcheck disable=SC2164
cd "${0%/*}" && cd "../../" \
	&&
	docker compose exec database mysql -u root -pvendon --execute="ALTER USER 'vendon'@'%' IDENTIFIED WITH mysql_native_password BY 'vendon';GRANT ALL PRIVILEGES ON *.* TO 'vendon'@'%' WITH GRANT OPTION;FLUSH PRIVILEGES;" \
	&& echo "user privileges updated!" \
	&& docker compose exec database mysql -u vendon -pvendon --execute="create database if not exists vendon;" \
	&& echo "Databases created!" \
	&& docker compose exec database bash -c "pv vendon.sql | gunzip |  mysql -u vendon -pvendon vendon" && echo 'vendon.sql imported'
