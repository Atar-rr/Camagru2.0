init: down build up

build: docker-build
up: mysql-down docker-up
down: docker-down
restart: down up

# Запуск контейнеров в режиме демонов
docker-up:
	docker-compose up -d

# Остановка контейнеров с удалением временных файлов
docker-down:
	docker-compose down --remove-orphans

# Сборка образов из dockerfile
docker-build:
	docker-compose build

# Войти в контейнер php
ds:
	docker-compose exec -u root php-fpm /bin/bash

# Сделать дамп базы mysql docker exec ef24f78a6630 /usr/bin/mysqldump -u ${PMA_USER} --password={DB_ROOT_PASSWORD} camagru > backup.sql
backup:
	 docker-compose exec mysql /usr/bin/mysqldump -u ${PMA_USER} --password=${DB_ROOT_PASSWORD} camagru > backup.sql

# Останавливаем mysql на хосте, если запущена
mysql-down:
	sudo service mysql stop
