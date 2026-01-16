# ./docker/php/Dockerfile
FROM php:8.4-fpm

# php.ini を反映
COPY php.ini /usr/local/etc/php/

# 必要パッケージ & PHP拡張（pdo_mysql, zip）
RUN apt-get update && apt-get install -y --no-install-recommends \
    default-mysql-client \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# UID=1000/GID=1000 の正規ユーザー app を作成（PsySH 用の設定ディレクトリも作成）
RUN groupadd -g 1000 app \
    && useradd -m -u 1000 -g 1000 -s /bin/bash app \
    && mkdir -p /home/app/.config/psysh \
    && chown -R app:app /home/app

# Tinker(PsySH) がホーム配下へ書けるように明示
ENV HOME=/home/app \
    XDG_CONFIG_HOME=/home/app/.config

# Composer を導入
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# アプリの作業ディレクトリ
WORKDIR /var/www
