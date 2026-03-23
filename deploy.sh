#!/usr/bin/env bash
set -euo pipefail

ENV_FILE=".env.production"
COMPOSE_FILE="docker-compose.prod.yml"

if [[ ! -f "$ENV_FILE" ]]; then
  echo "[ERROR] Missing $ENV_FILE. Copy from .env.production.example first."
  exit 1
fi

echo "[1/5] Pull latest source..."
git pull --rebase

echo "[2/5] Build and start containers..."
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" up -d --build

echo "[3/5] Install PHP dependencies..."
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" exec -T app composer install --no-dev --optimize-autoloader

echo "[4/5] Run migrations and create storage link..."
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" exec -T app php artisan migrate --force
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" exec -T app php artisan storage:link || true

echo "[5/5] Cache optimize..."
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" exec -T app php artisan config:cache
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" exec -T app php artisan route:cache
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" exec -T app php artisan view:cache

echo "Deploy completed."
