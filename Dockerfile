FROM php:8.3-apache

# Installation des extensions PHP nécessaires à Laravel et SQL
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Activation de mod_rewrite d'Apache
RUN a2enmod rewrite

# Configuration du dossier public comme racine web
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
COPY . .

# Installation de Composer et des dépendances
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Script de démarrage (migrations + lancement Apache)
COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]