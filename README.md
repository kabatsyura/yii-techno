# app

## man to run project

1. git clone & git pull
2. create .env use .env.example
3. run `docker compose up -d`
4. in php-fpm container run `php init`
5. in php-fpm container run `composer install`
6. in php-fpm container run `php yii migrate`
7. in php-fpm container run `php yii user/create-default phone password`
