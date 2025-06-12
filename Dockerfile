# Stage 1: Build Composer dependencies and PHP extensions
FROM php:8.3-fpm-alpine as composer_builder

# Instala dependências do sistema necessárias para as extensões PHP
RUN apk add --no-cache \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    mysql-client \
    git \
    build-base \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    libfreetype6-dev \
    freetype-dev # Adicione freetype-dev para garantir GD completo

# Instala extensões PHP
# Use docker-php-ext-install para extensões nativas
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath zip
# Para a extensão gd, precisamos de uma etapa adicional para Alpine
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Instala Composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Define o diretório de trabalho para o Composer
WORKDIR /app

# Copia composer.json e composer.lock
COPY composer.json composer.lock ./

# Instala dependências do Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts --prefer-dist

# Stage 2: Final image for the Laravel application
FROM php:8.3-fpm-alpine

# Instala dependências do sistema para servir o Laravel, incluindo Nginx
# CORREÇÃO AQUI: Simplifiquei os nomes de algumas libs
RUN apk add --no-cache \
    nginx \
    curl \
    # Dependências mínimas para o runtime
    postgresql-libs \ 
    libzip \
    libjpeg-turbo \
    libpng \
    freetype 

# Define o diretório de trabalho dentro do contêiner para a aplicação
WORKDIR /var/www/html

# Copia o código da aplicação
COPY . .

# Copia as dependências do Composer da stage de build
COPY --from=composer_builder /app/vendor /var/www/html/vendor

# Configura o Nginx para Laravel
# Este arquivo 'nginx.conf' deve estar na pasta 'docker/' na raiz do seu projeto
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Define permissões para o Laravel (essencial para cache, logs, uploads)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Define as permissões para a pasta public
RUN find /var/www/html/public -type d -exec chmod 755 {} \; \
    && find /var/www/html/public -type f -exec chmod 644 {} \;

# Expõe a porta 8080 (Render escuta nesta porta)
EXPOSE 8080

# Comando para iniciar o PHP-FPM e o Nginx
CMD ["sh", "-c", "php-fpm && nginx -g \"daemon off;\""]
