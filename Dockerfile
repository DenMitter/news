FROM php:8.1-fpm

# Встановлюємо необхідні PHP розширення
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Якщо потрібно розширення curl
RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install curl