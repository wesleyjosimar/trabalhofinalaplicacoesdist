#!/bin/sh
set -e

# Limpar caches antes de começar
echo "Limpando caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Verificar se APP_KEY está configurado
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:GERAR_DEPOIS" ] || [ "$APP_KEY" = "base64:GERAR_AQUI" ]; then
    echo "AVISO: APP_KEY não configurado. Gerando..."
    php artisan key:generate --force || true
fi

# Executar migrations (se necessário)
if [ "$RUN_MIGRATIONS" != "false" ]; then
    echo "Executando migrations..."
    php artisan migrate --force || echo "ERRO: Falha ao executar migrations"
fi

# Executar seed (apenas na primeira vez, se necessário)
if [ "$RUN_SEED" = "true" ]; then
    echo "Executando seed..."
    php artisan db:seed --force || echo "AVISO: Falha ao executar seed"
fi

# Cache de configurações (apenas se não houver erro)
echo "Otimizando aplicação..."
php artisan config:cache || echo "AVISO: Falha ao cachear config"
php artisan route:cache || echo "AVISO: Falha ao cachear rotas"
php artisan view:cache || echo "AVISO: Falha ao cachear views"

# Executar comando principal
echo "Iniciando servidor..."
exec "$@"

