init: docker-pull docker-build-pull docker-up app-init

clear: docker-down-clear

start: docker-up

stop: docker compose down

test:
	./vendor/bin/phpunit --color=always

docker-up:
	docker compose up

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build-pull:
	docker compose build --pull

app-init: composer install
