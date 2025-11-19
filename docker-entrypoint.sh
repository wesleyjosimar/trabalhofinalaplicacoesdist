#!/bin/sh
set -e

# Executar migrations (se necessário)
if [ "$RUN_MIGRATIONS" != "false" ]; then
    echo "Executando migrations..."
    php artisan migrate --force || true
fi

# Executar seed (apenas na primeira vez, se necessário)
if [ "$RUN_SEED" = "true" ]; then
    echo "Executando seed..."
    php artisan db:seed --force || true
fi

# Cache de configurações
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Executar comando principal
exec "$@"

