# Utilise l'image officielle PHP + Apache
FROM php:8.2-apache

# Installer les dépendances nécessaires pour PostgreSQL et activer modules
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# 1. Copier le contenu de votre dossier 'www' dans le répertoire web d'Apache.
COPY www/ /var/www/html

# 2. Configurer Apache pour que le DocumentRoot pointe vers le dossier 'public'.
RUN echo "<VirtualHost *:80>" > /etc/apache2/sites-available/000-default.conf \
    && echo "DocumentRoot /var/www/html/public" >> /etc/apache2/sites-available/000-default.conf \
    && echo "</VirtualHost>" >> /etc/apache2/sites-available/000-default.conf

# 3. Activer le traitement des fichiers .htaccess (AllowOverride All) pour le dossier public.
RUN echo "<Directory /var/www/html/public>" >> /etc/apache2/apache2.conf \
    && echo "    AllowOverride All" >> /etc/apache2/apache2.conf \
    && echo "    Require all granted" >> /etc/apache2/apache2.conf \
    && echo "</Directory>" >> /etc/apache2/apache2.conf

# 4. Activer la configuration par défaut (CRUCIAL)
RUN a2ensite 000-default.conf

# 5. --- FIX FOR VOLUME PERMISSIONS ---
# Create a dummy entrypoint script to fix permissions on mount
RUN echo '#!/bin/sh' > /usr/local/bin/fix-perms-entrypoint.sh \
    && echo 'chown -R www-data:www-data /var/www/html' >> /usr/local/bin/fix-perms-entrypoint.sh \
    && echo 'exec "$@"' >> /usr/local/bin/fix-perms-entrypoint.sh \
    && chmod +x /usr/local/bin/fix-perms-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/fix-perms-entrypoint.sh"]
CMD ["apache2-foreground"]

# Permettre à Apache d'écrire sur le dossier (This line is now redundant but we keep it)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80