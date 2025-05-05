# pohodnik-api
api for pohodnik

### Настройка проекта :hourglass_flowing_sand:	
> **выполняется один раз перед запуском проекта**
> или по мере надобности 
 1. `startHosts_ONCE.bat` или добавть запись `127.0.0.1 pohodnik.tk` в hosts, чтобы pohodnik.tk открывался локальным


### Запуск проекта :rocket:
```bash
docker-compose up
```
или `start.bat`

после старта доступны:
* http://pohodnik.tk - http версия сайта
* http://localhost:8001 - phpMyAdmin (MySql database)

phpmyadmin pohodnik.tk:8001


`docker-compose down`
Delete all containers using the following command:
`docker rm -f $(docker ps -a -q)`
Delete all volumes using the following command:
`docker volume rm $(docker volume ls -q)`
Restart the containers using the following command:
`docker-compose up -d`

### config

`.env`

```php
MYSQL_PORT=3307
HTTP_PORT=80
TZ=Europe/Moscow

MYSQL_HOST=mysql
MYSQL_ROOT_PASSWORD=111111111
MYSQL_DATABASE=pohodnik
MYSQL_USER=pohodnik
MYSQL_PASSWORD=1111111111
MIGRATOR_USER=pohodnik
MIGRATOR_PASSWORD=1111111111111
CLOUDINARY_URL='cloudinary://11111111111111:ub9BSwTuqaba2bbsOiD_xofaqbk@poh222'
SMTP_HOST='smtp.yandex.ru'
SMTP_USER='pohodnik@ya.ru'
SMTP_PSW='11111111111111111'
SMTP_PORT=465
SMTP_DEBUG=

VK_CLIENT_ID=000000000
VK_CLIENT_SECRET=dddddddddd
TG_CLIENT_ID=pohodnik58Bot
TG_CLIENT_SECRET=0000000:aaaaaaaaaaaa
YANDEX_CLIENT_ID=q1q1w2e3e23e
YANDEX_CLIENT_SECRET=213edwq3edw23ewq
GOOGLE_CLIENT_ID=123213weqde21ewsq21
GOOGLE_CLIENT_SECRET=qweqw12312eqw
STRAVA_CLIENT_ID=000000000000
STRAVA_CLIENT_SECRET=22222222dsqae213eswqa
FACEBOOK_CLIENT_ID=2139245699623747
FACEBOOK_CLIENT_SECRET=21esdq324e2qw65yhgtr
OK_CLIENT_ID=000000000
OK_CLIENT_SECRET=67ujhty76u5
OK_PUBLIC_KEY=DEDWDWDSCSFECEDS
MAILRU_CLIENT_ID=00000
MAILRU_CLIENT_SECRET=78ikuy78i78i8i8

```


