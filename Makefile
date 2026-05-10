install:
	composer install
	npm ci
	npm run build 
	cp -n .env.example .env || true
	php artisan key:generate --ansi
	touch database/database.sqlite
	php artisan migrate --force --seed

lint:
	composer exec phpcs -- --standard=PSR12 routes tests app

test:
	php artisan test

test-coverage:
	php artisan test --coverage-clover=coverage.xml