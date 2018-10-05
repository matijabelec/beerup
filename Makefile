
install:
	docker run --rm --interactive --tty --volume ${PWD}/project:/app \
		composer:1.7.2 install --ignore-platform-reqs

up:
	cd docker && docker-compose up -d

down:
	cd docker && docker-compose down --volumes

status:
	cd docker && docker-compose ps

composer:
	docker run --rm --interactive --tty --volume ${PWD}/project:/app \
		composer:1.7.2 $(filter-out $@, $(MAKECMDGOALS)) --ignore-platform-reqs

phpunit:
	./docker/bin/phpunit $(filter-out $@, $(MAKECMDGOALS))

%:
	@true
