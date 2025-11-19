#!/usr/bin/env bash

# Build script para Render

echo "Instalando dependências..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Executando migrations..."
php artisan migrate --force

echo "Build concluído!"

