#!/bin/sh
# shellcheck disable=SC2164
cd "${0%/*}"
cd ../../../ || exit
zip -r "dump-$(date +%Y-%m-%d)".zip Vendon
echo 'Project Dumped!'
