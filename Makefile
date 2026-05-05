lint:
	composer exec phpcs -- --standard=PSR12 routes tests app

test:
	php artisan test