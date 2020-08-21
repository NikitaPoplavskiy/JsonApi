## Install
git clone https://github.com/NikitaPoplavskiy/JsonApi.git
cd JsonApi
composer update
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

## консольная команда, которая читает два файла JSON: ReadJson
