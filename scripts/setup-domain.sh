#!/usr/bin/env bash
#====================================================
# Setup domain bactrang.com + SSL on VPS
# Run this script on VPS (NOT in Docker)
# Usage: bash scripts/setup-domain.sh your-email@gmail.com
#====================================================
set -euo pipefail

DOMAIN="bactrang.com"
WWW_DOMAIN="www.bactrang.com"
EMAIL="${1:-}"

if [[ -z "$EMAIL" ]]; then
  echo "[ERROR] Vui long truyen email de dang ky SSL."
  echo "Usage: bash scripts/setup-domain.sh your-email@gmail.com"
  exit 1
fi

echo "=============================================="
echo "  Setup domain: $DOMAIN"
echo "  Email SSL:    $EMAIL"
echo "=============================================="

# 1. Install Nginx & Certbot on host
echo "[1/5] Cai dat Nginx va Certbot tren host..."
apt update
apt install -y nginx certbot python3-certbot-nginx

# 2. Create Nginx site config (reverse proxy to Docker on port 8080)
echo "[2/5] Tao Nginx config cho $DOMAIN..."
cat > /etc/nginx/sites-available/$DOMAIN << NGINX_CONF
server {
    listen 80;
    server_name $DOMAIN $WWW_DOMAIN;

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_read_timeout 300s;
        proxy_connect_timeout 75s;
        client_max_body_size 20M;
    }
}
NGINX_CONF

# 3. Enable site, disable default
echo "[3/5] Kich hoat site va restart Nginx..."
ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test nginx config
nginx -t

# Restart Nginx
systemctl restart nginx
systemctl enable nginx

# 4. Rebuild Docker containers with new port (8080)
echo "[4/5] Rebuild Docker containers (port 8080)..."
cd /var/www/du_an_cntt_2_web_php
docker compose --env-file .env.production -f docker-compose.prod.yml up -d --force-recreate web

# 5. Request SSL certificate
echo "[5/5] Xin chung chi SSL tu Let's Encrypt..."
certbot --nginx \
  -d $DOMAIN \
  -d $WWW_DOMAIN \
  --non-interactive \
  --agree-tos \
  -m "$EMAIL" \
  --redirect

# 6. Setup auto-renew cron (Certbot usually does this automatically)
echo ""
echo "=============================================="
echo "  HOAN THANH!"
echo "=============================================="
echo ""
echo "Domain:  https://$DOMAIN"
echo "WWW:     https://$WWW_DOMAIN"
echo ""
echo "SSL tu dong gia han boi Certbot (cron)."
echo ""
echo "QUAN TRONG: Hay cap nhat .env.production:"
echo "  APP_URL=https://$DOMAIN"
echo ""
echo "Sau do chay:"
echo "  cd /var/www/du_an_cntt_2_web_php"
echo "  docker compose --env-file .env.production -f docker-compose.prod.yml up -d --force-recreate app"
echo "  docker compose --env-file .env.production -f docker-compose.prod.yml exec -T app php artisan config:cache"
echo ""
