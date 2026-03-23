# Docker Production-like Local Setup

This setup runs:
- Nginx (port `8080`)
- PHP-FPM (`app` service)
- MySQL 8 (`db` service, mapped to host port `3307`)

## 1) Start services

```bash
docker compose up -d --build
```

## 2) Install dependencies and app key

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan storage:link
```

## 3) Build frontend assets (required for production-like mode)

Run on host:

```bash
npm install
npm run build
```

## 4) Prepare database

```bash
docker compose exec app php artisan migrate --force
```

## 5) Open app

`http://localhost:8080`

## Optional: import old SQL dump

```bash
docker compose exec -T db mysql -uroot -proot_pass ecommerce_prod_like < backup.sql
```

## VPS production flow (later)

```bash
cp .env.production.example .env.production
# edit .env.production values first
chmod +x deploy.sh
./deploy.sh
```

Production compose file: `docker-compose.prod.yml`
