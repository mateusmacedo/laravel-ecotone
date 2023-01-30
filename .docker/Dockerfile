#---------------------------------------------------
# FINAL IMAGE
#---------------------------------------------------

# Image
FROM macedodosanjosmateus/laravel-startkit:base

# Variables
ENV DOCUMENT_ROOT /var/www/localhost/htdocs

RUN apk add --no-cache \
    && apk del --no-cache \
        gcc \
        g++ \
        make \
        perl \
        autoconf \
        dpkg-dev \
        dpkg \
        file \
        libc-dev \
        pkgconf \
        re2c

# Workdir
WORKDIR $DOCUMENT_ROOT

# Remove NGINX old
RUN rm -f /etc/nginx/conf.d/*

# Copy app and configs
COPY . $DOCUMENT_ROOT
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY .docker/php/daemon-process.conf /etc/supervisor/supervisord.conf
COPY .docker/php/php-fpm-www.conf /usr/local/etc/php-fpm.d/www.conf
# COPY .docker/php/op-cache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN chown -R www-data:www-data $DOCUMENT_ROOT

RUN ln -sf /dev/stdout /var/log/nginx/access.log && ln -sf /dev/stderr /var/log/nginx/error.log

# Expose port
EXPOSE 80 9000

# Start APP
CMD ["nginx", "-g", "daemon off;"]
RUN chmod +x .docker/scripts/entrypoint.sh
ENTRYPOINT [".docker/scripts/entrypoint.sh"]
