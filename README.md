################

Спецификация API - https://docs.google.com/document/d/1VYG89hHhm6mY6KZw7SZCX-Xna8EUKvGjn4kdKEzialM/edit#

################

Для запуска API потребуется :

1. PHP 8.0.2 и выше, установленный глобально.
2. Composer установленный глобально.
3. БД MySQL , БД-драйвер InnoDB


Установка Composer :

После установки PHP, заходим в папку проекта и устанавливаем composer ( composer install в консоли папки проекта).
Далее выполняем composer update, далее редактируем .env хост и пароль от контейнера вашей БД. После этого php artisan serve - позволит запустить API



Установка MySQL

Устанавливаем DockerDesktop, далее перезагружаем компьютер и после перезагрузки в терминале вводим: 

docker pull mysql:8.0

docker run --name cdp --restart unless-stopped -e MYSQL_ROOT_PASSWORD=CDPPASSWORD -p 3306:3306 -d mysql:latest

В указанном выше скрипте, пароли и названия таблицы условны.

USER - root
PASSWORD - CDPPASSWORD

################


Запуск Swagger-документации :

php artisan l5-swagger:generate - для генерации документации ( или если что-то пошло не так)

Далее переходим по роуту http://localhost:8000/api/documentation
