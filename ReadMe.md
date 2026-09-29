# Vendon Quiz

Small PHP quiz application. The local Docker setup uses PHP 8.3, Nginx and MySQL 8.4.

## Run locally

```sh
cp .env.example .env
docker compose build app
docker compose run --rm --no-deps app composer install --no-interaction
docker compose up -d --wait
```

Open http://localhost:8082 (or set `HTTP_PORT` in `.env`). No hostname override or TLS files are needed for this local setup. The checked-in SQL fixture is imported automatically when the database volume is first created. Existing database volumes are preserved.

The application takes database settings from the Compose environment; the old `dbData.json` configuration remains a fallback for installations outside Docker.

To stop the local stack, run `docker compose down`. To run optional development overrides, use `docker compose -f docker-compose.yaml -f compose-dev.yaml up -d`.

Database settings come from the Compose environment. A standalone PHP installation can supply the same `DB_HOST`, `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` variables; local `dbData.json` overrides are ignored by Git.
