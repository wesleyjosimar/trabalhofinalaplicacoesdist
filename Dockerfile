FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos
COPY . /var/www

# Criar .env temporário para o build
RUN touch /var/www/.env && \
    echo "APP_KEY=" > /var/www/.env

# Instalar dependências (sem scripts que precisam do artisan)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts && \
    composer dump-autoload --optimize --no-scripts

# Configurar permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Expor porta (Render injeta $PORT dinamicamente)
EXPOSE 8000

# Scripts de inicialização
COPY docker-entrypoint.sh /usr/local/bin/
COPY start-server.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh && \
    chmod +x /usr/local/bin/start-server.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["start-server.sh"]

