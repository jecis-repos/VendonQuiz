
## Installation

Clone repository

Open root directory and run

```bash
 docker compose up -d
```
Looks like automated import dosen't work so import database manually from file docker/mysql_dump/vendon.sql
```bash
docker/mysql_dump/vendon.sql
```
If you want to browse url not as localhot ten add
```bash
 127.0.0.1 dodiesturp.lv
 ```
to
```bash
/ect/hosts
```

It looks like there is necessity to run composer install so run command 
```bash
docker compose exec app fish -c "composer install"
```
Open url and enjoy :) 
