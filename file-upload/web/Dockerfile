FROM php:8.1-apache
#Install pdo pdo_mysql mysqli 
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite
COPY src/ /var/www/html/
RUN /bin/bash -c "chown -R www-data:www-data /var/www/html"
 
EXPOSE 80
