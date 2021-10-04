config:
	- docker-compose run php php artisan config:cache
npm:
	- docker-compose run npm run watch
php:
	- docker-compose run php sh
up:
	- docker-compose up -d
down:
	- docker-compose down
stop:
	- docker-compose stop
autoload:
	- docker-compose run composer dump-autoload