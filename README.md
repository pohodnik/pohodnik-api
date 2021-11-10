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

`_config.php`

```php
<?php
    return array(
        'MYSQL_HOST'=> '***',
        'MYSQL_ROOT_PASSWORD'=> '***',
        'MYSQL_DATABASE'=> '***',
        'MYSQL_USER'=> '***',
        'MYSQL_PASSWORD'=> '***',
        'MIGRATOR_USER'=> '***',
        'MIGRATOR_PASSWORD'=> '***',
        'CLOUDINARY_URL'=> 'cloudinary://***:***@***'
    );
```