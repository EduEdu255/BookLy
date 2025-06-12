# Stage 1: Build Composer dependencies and PHP extensions
FROM php:8.3-fpm-alpine as composer_builder

# Instala dependências do sistema necessárias para as extensões PHP
RUN apk update && apk add --no-cache \
    curl \
    postgresql-dev \
    unzip \
    mysql-client \
    git \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make \
    libzip-dev \
    pkgconf

# Instala extensões PHP
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath zip
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
RUN apk add --no-cache \
    nginx \
    curl \
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

# PASSO CRUCIAL AQUI: Cria o arquivo de configuração principal do Nginx
# Ele garante que o bloco 'http' existe e inclui os arquivos de conf.d
RUN echo "events { worker_connections 1024; }" > /etc/nginx/nginx.conf \
    && echo "http { include /etc/nginx/conf.d/*.conf; }" >> /etc/nginx/nginx.conf \
    && echo "pid /run/nginx.pid;" >> /etc/nginx/nginx.conf \
    && echo "daemon off;" >> /etc/nginx/nginx.conf # Render precisa que ele rode em foreground

# Copia a configuração do Laravel Nginx para conf.d
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

# Adiciona STOPSIGNAL para encerramento elegante
STOPSIGNAL SIGQUIT

# Comando para iniciar o PHP-FPM e o Nginx
# Primeiro, testa a configuração do Nginx. Se estiver OK, inicia ambos os serviços.
# As aspas simples em 'daemon off;' são importantes para o sh -c
CMD ["sh", "-c", "nginx -t && php-fpm && nginx -g 'daemon off;'"]
