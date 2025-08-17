init: env up

env:
	@echo "Копируем .env.example в .env..."
	@cp -n .env-example .env || true
	@echo "Файл .env создан (или уже существовал)"

up:
	@echo "Запускаем docker-compose..."
	@docker compose up -d

down:
	@echo "Останавливаем контейнеры..."
	@docker compose down

bash:
	@echo "Вход в контейнер php-fpm..."
	@docker exec -it techno_php_fpm bash

install:
	@echo "Установка зависимостей composer..."
	@docker exec techno_php_fpm composer install

init-db: migrate create-user

migrate:
	@echo "Применение миграций..."
	@docker exec techno_php_fpm php yii migrate --interactive=0

create-user:
	@echo "Создание пользователя по умолчанию..."
	@docker exec techno_php_fpm php yii user/create-default phone password