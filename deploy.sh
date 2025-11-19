#!/usr/bin/env bash

# Script de deploy para Render

echo "Executando migrations..."
php artisan migrate --force

echo "Criando usuários padrão (se necessário)..."
php artisan db:seed --force || true

echo "Limpando caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Otimizando para produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deploy concluído!"

