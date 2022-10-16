FROM php:8.0-apache

USER root

COPY web.conf /etc/apache2/sites-available/web.conf

COPY start-web /usr/local/bin

RUN a2enmod rewrite

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y libpq-dev \
    && apt-get install -y git \
    && composer install --no-dev


#RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
#    a2enmod rewrite && \
#    a2dissite 000-default && \
#    a2ensite web && \
#    service apache2 restart

CMD ["start-web"]