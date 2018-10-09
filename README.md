# Beerup

## Requirements

To locally install project, a few required tools are needed:

- docker & docker-compose (compatible with version 3 compose files)
- make
- unix/osx (on windows probably automatized scripts are not usable)

## Technical documentation

Available endpoints and how to use them is described in [Project technical documentation](docs/TECHDOC.md)

## Installation

To install locally you can just run following command:

```bash
$ make install
```

## Local development

### Prepare git hooks

There is prepared git hooks for `pre-commit` with `php-cs-fixer`. To install hook use:

```bash
$ cd <project-root>
$ ln -s _git/hooks/pre-commit .git/hooks/pre-commit
```

### Docker

A few make options are added for docker-compose simplification:

```bash
$ #docker-compose up -d
$ make up

$ #docker-compose down --volumes
$ make down

$ #docker-compose ps
$ make status
```

All helper scripts are in `docker/bin` directory.

## Tests

Phpunit executable can be run throgh docker container with:

```bash
$ cd <project-root>
$ ./docker/bin/phpunit
```
