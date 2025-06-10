# Usa uma imagem PHP-FPM base
FROM php:8.3-fpm

# Instalar extensões e dependências para Laravel
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
    libzip-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho dentro do contêiner
WORKDIR /var/www

# COPIAR O CÓDIGO FONTE PARA O CONTÊINER ANTES DE RODAR O COMPOSER INSTALL
# Isso garante que o composer.json esteja presente durante o build
COPY . /var/www

# Configurar permissões para o Laravel (essencial para cache, logs, uploads)
# Garante que o usuário www-data (usado pelo PHP-FPM) seja o proprietário
RUN chown -R www-data:www-data /var/www

# Define permissões específicas para pastas que o Laravel precisa escrever
RUN chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Define permissões para a pasta public.
# d=diretórios, f=arquivos. Garante que diretórios tenham permissão de execução para entrar neles.
RUN find /var/www/public -type d -exec chmod 755 {} \; \
    && find /var/www/public -type f -exec chmod 644 {} \;

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]