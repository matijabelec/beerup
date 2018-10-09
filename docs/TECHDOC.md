# Beerup technical documentation

## General

### Resource response example

```json

{
    "data": {
        "type": "beers",
        "id": "2",
        "attributes": {
            "name": "Trashy Blo",
            "description": "A titillating, neurotic...",
            "abv": 4.1,
            "ibu": 41.5,
            "image_url": "https://..."
        }
    }
}
```

### Collection response example

```json

{
    "data": [
        {
            "type": "beers",
            "id": "1",
            "attributes": {
                "name": "Buz",
                "description": "A light, crisp and bitter...",
                "abv": 4.5,
                "ibu": 60,
                "image_url": "https://..."
            }
        },
        {
            "type": "beers",
            "id": "2",
            "attributes": {
                "name": "Trashy Blo",
                "description": "A titillating, neurotic...",
                "abv": 4.1,
                "ibu": 41.5,
                "image_url": "https://..."
            }
        }
    ]
}
```

### Error response example

```json
{
    "errors": [
        {
            "status": 404,
            "title": "Not Found",
            "detail": "Beer with id 11 not found"
        }
    ]
}
```

## Auth / Simple login

**POST /tokens**
Request:
```json
{
    "data": {
      "username": "something"
    }
}
```
Response:
{
    "data": {
        "type": "tokens",
        "id": 0,
        "attribute": {
            "token": "eyJ0eXAiOiJKV1QiLCJhbGc...Nwgds9Z0"
        }
    }
}

## Beers

### Fetch collection of beers

**GET /beers?orderBy=id&page=2**
- parameters:
  - `orderBy` - page
  - `page` - page index (first page index is `1`)

### Fetch details about one beer

**GET /beers/{id}**
- arguments:
  - `id` - id of beer entity

### Create beer

**POST /beers**
Request:
```json
{
    "data": {
        "name": "The beer",
        "description": "Beer description...",
        "abv": 4.6,
        "ibu": 50.5,
        "image_url": null
    }
}
```
Response (201):
```
Headers:
Location →/beers/12
```

### Update beer

**PUT /beers/{id}**
Request:
```json
{
    "data": {
        "name": "The beer",
        "description": "Beer description...",
        "abv": 4.6,
        "ibu": 50.5,
        "image_url": null
    }
}
```
Response (204)

### Delete beer

**DELETE /beers/{id}**
Response (204)

## Favorite beers

### Fetch collection of favorite beers

**GET /favorite-beers**

### Add favorite beer

**Post /favorite-beers/{id}**
Request:
```json
{
    "data": {
        "beer_id": 3
    }
}
```
Response (204)

### Remove favorite beer

**DELETE /favorite-beers/{id}**
Response (204)

## CLI

### Import beers

Import multiple beers into local database with import command:

```bash
$ ./docker/bin/console beers:import {number-of-beers}
```
- arguments:
`number-of-beers` - number of beer entities to fetch from external api
