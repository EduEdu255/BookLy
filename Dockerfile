FROM php:8.3-fpm

# Instalar extensões e dependências
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto (serão sobrescritos pelo volume, mas necessário para build)
COPY . .

# Instalar dependências do Laravel
RUN composer install

# Dar permissões corretas
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
