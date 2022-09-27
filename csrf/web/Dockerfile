FROM php:8.1-apache
#Install pdo pdo_mysql mysqli 
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite
COPY src/ /var/www/html/
RUN /bin/bash -c "chown -R www-data:www-data /var/www/html"

# Install phantomjs
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        bzip2 \
        libfontconfig \
				curl \ 
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir /tmp/phantomjs
COPY phantomjs-2.1.1-linux-x86_64.tar.bz2 /tmp/phantomjs/phantomjs-2.1.1-linux-x86_64.tar.bz2
RUN tar -xjf /tmp/phantomjs/phantomjs-2.1.1-linux-x86_64.tar.bz2 --strip-components=1 -C /tmp/phantomjs \
    && cd /tmp/phantomjs \
    && mv bin/phantomjs /usr/local/bin \
    && cd \
    && apt-get purge --auto-remove -y \
        curl \
    && apt-get clean \
    && rm -rf /tmp/* /var/lib/apt/lists/*

COPY bot.js /opt/phantomjs/
COPY run-bot.sh /opt/phantomjs/

ENTRYPOINT [ "/opt/phantomjs/run-bot.sh" ]
 
EXPOSE 80
