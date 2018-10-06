
install:
	docker run --rm --interactive --tty --volume ${PWD}/project:/app \
		composer:1.7.2 install --ignore-platform-reqs

up:
	cd docker && docker-compose up -d
	sleep 15
	./docker/bin/init/database
	./docker/bin/console doctrine:database:create
	./docker/bin/console --no-interaction doctrine:migrations:migrate

down:
	cd docker && docker-compose down --volumes

status:
	cd docker && docker-compose ps

analyse:
	./docker/bin/phpstan analyse src tests
