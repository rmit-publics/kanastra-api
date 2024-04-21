FROM php:8.1.9-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
WORKDIR ${APACHE_DOCUMENT_ROOT}

# Instalação do Git
RUN apt-get update && apt-get install -y git

# install dependencies
RUN apt-get update && apt-get install -y \
	cron \
	libpng-dev \
	zlib1g-dev
# setup apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
		/etc/apache2/sites-available/*.conf \
	&& \
	sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
		/etc/apache2/apache2.conf \
		/etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# install php extensions
RUN apt-get update && apt-get install -y \
		libicu-dev \
	&& docker-php-ext-install \
		intl \
		opcache \
	&& docker-php-ext-enable \
		intl \
		opcache \
	&& docker-php-ext-install pdo pdo_mysql \
	&& docker-php-ext-install mysqli
RUN apt-get install -y zip unzip zlib1g-dev

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
	--install-dir=/usr/local/bin \
	--filename=composer

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 100M;" >> /usr/local/etc/php/conf.d/uploads.ini

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size  = 100M;" >> /usr/local/etc/php/conf.d/uploads.ini

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=-1;" >> /usr/local/etc/php/conf.d/uploads.ini

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time=-1;" >> /usr/local/etc/php/conf.d/uploads.ini

ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# setup application files
COPY ./ /var/www/html/

RUN chmod -R 777 /var/www/html/storage/