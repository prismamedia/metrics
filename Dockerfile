ARG PHP_VERSION

FROM php:${PHP_VERSION}-cli-alpine AS php

WORKDIR /app

RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
      	linux-headers \
    ; \
	\
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
	pecl clear-cache; \
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .app-phpexts-rundeps $runDeps; \
	\
	apk del .build-deps


# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY --from=composer/composer:2-bin --link /composer /usr/bin/composer
