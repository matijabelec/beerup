
install:
	docker run --rm --interactive --tty --volume ${PWD}/project:/app \
		composer:1.7.2 create-project symfony/skeleton beerup --ignore-platform-reqs
	mv project/beerup/* project/
	mv project/beerup/.[!.]* project/
	rmdir project/beerup
