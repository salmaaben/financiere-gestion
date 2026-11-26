FROM php:8.3-apache

# Installation des dépendances système et extensions PHP nécessaires à Laravel, SQL et GD
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libpq-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql pdo_pgsql zip gd \
    && rm -rf /var/lib/apt/lists/*

# Activation de mod_rewrite d'Apache
RUN a2enmod rewrite

# Configuration du dossier public comme racine web
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Autoriser Git sur /var/www/html pour éviter "dubious ownership"
RUN git config --system --add safe.directory /var/www/html \
    && git config --global --add safe.directory /var/www/html

# Installation de Composer et des dépendances
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copie ciblée de l'application (protégée aussi par .dockerignore)
COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY public ./public
COPY resources ./resources
COPY routes ./routes
COPY artisan ./artisan

# Permissions Laravel et exécution des scripts post-install
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} /var/www/html/storage/logs /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Script de démarrage (migrations + lancement Apache)
COPY start.sh /start.sh
RUN chmod +x /start.sh

USER www-data

CMD ["/start.sh"]