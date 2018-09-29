FROM php:7.2-cli

WORKDIR /tmp

# 辅助命令安装
RUN apt-get update \
    && apt-get install -y procps \
    && apt-get install -y cmake  \
    && apt-get install -y iputils-ping \
    && apt-get install -y libpcre3 libpcre3-dev

# 安装swoole扩展
RUN cd /usr/local/src \
    && curl -O http://pecl.php.net/get/swoole-1.10.5.tgz \
    && tar -zxf swoole-1.10.5.tgz \
    && cd swoole-1.10.5 \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && docker-php-ext-enable swoole

# 安装xdebug
RUN cd /usr/local/src \
    && curl -O http://pecl.php.net/get/xdebug-2.6.1.tgz \
    && tar -zxf xdebug-2.6.1.tgz \
    && cd xdebug-2.6.1 \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && docker-php-ext-enable xdebug


RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pcntl \
    && docker-php-ext-enable opcache \
    && rm -rf /tmp/pear \
    && cd /usr/local/src \
    && curl -O https://codeload.github.com/Qihoo360/QConf/tar.gz/1.2.1 \
    && tar -zxf 1.2.1 \
    && cd QConf-1.2.1 \
    && mkdir build && cd build && cmake .. && make && make install \
    && cd /usr/local/src/QConf-1.2.1/driver/php \
    && phpize \
    && ./configure --with-php-config=/usr/local/bin/php-config --with-libqconf-dir=/usr/local/qconf/include --enable-static LDFLAGS=/usr/local/qconf/lib/libqconf.a \
    && make && make install \
    && docker-php-ext-enable qconf


ENV DIRPATH /media/raid10/htdocs/services/register/

COPY . $DIRPATH

WORKDIR $DIRPATH

EXPOSE 80

RUN chmod +x $DIRPATH/start.sh

CMD ["./start.sh", "dev"]