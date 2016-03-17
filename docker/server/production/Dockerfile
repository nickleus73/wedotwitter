FROM ubuntu:trusty
MAINTAINER MORICET Nicolas <moricet.nicolas@free.fr>

########################################################################################################################
# INSTALLATION OF PACKAGES
########################################################################################################################
RUN install=" \
		git \
		ruby \
		software-properties-common \
		python-software-properties \
		build-essential \
        ca-certificates \
        wget \
        curl \
        locales \
        libpcre3  \
        librecode0  \
        libsqlite3-0  \
        libpq-dev  \
        autoconf  \
        file  \
        g++  \
        gcc  \
        libc-dev  \
        make  \
        pkg-config  \
        re2c \
        curl \
        libpq5 \
		libpng++-dev \
		libpng12-dev \
		spawn-fcgi \
		libcurl4-openssl-dev \
		libpcre3-dev \
		libreadline6-dev \
		librecode-dev \
		libsqlite3-dev \
		libssl-dev \
		libxml2-dev \
		xz-utils \
		libjpeg-dev \
    " \
    && apt-get update \
    && apt-get install -y $install --no-install-recommends

########################################################################################################################
# INSTALLATION POSTGRES
########################################################################################################################
ENV PG_MAJOR  9.5
#ENV PG_VERSION 9.4.4-1.pgdg80+1
ENV PATH /usr/lib/postgresql/$PG_MAJOR/bin:$PATH
ENV PGDATA /var/lib/postgresql/data

RUN add-apt-repository "deb http://apt.postgresql.org/pub/repos/apt/ trusty-pgdg main"
RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
RUN apt-get update

RUN install=" \
        postgresql-$PG_MAJOR \
        postgresql-contrib \
        postgresql-common \
	" \
	&& apt-get update \
    && apt-get install -y $install --no-install-recommends

########################################################################################################################
# INSTALL APACHE
########################################################################################################################
RUN install=" \
		apache2-dev \
        apache2 \
        apache2-bin \
	" \
	&& apt-get update \
    && apt-get install -y $install --no-install-recommends

RUN rm -rf /var/www/html \
    && mkdir -p /var/lock/apache2 /var/run/apache2 /var/log/apache2 /var/www/html \
    && chown -R www-data:www-data /var/lock/apache2 /var/run/apache2 /var/log/apache2 /var/www/html

RUN a2dismod mpm_event \
    && a2enmod mpm_prefork \
    && a2enmod rewrite \
    && a2enmod ssl

RUN mv /etc/apache2/apache2.conf /etc/apache2/apache2.conf.dist  \
    && rm /etc/apache2/conf-enabled/* /etc/apache2/sites-enabled/*

COPY apache2.conf /etc/apache2/apache2.conf


########################################################################################################################
# BUILD PHP
########################################################################################################################
ENV PHP_VERSION 7.0.3
ENV PHP_INI_DIR /usr/local/etc/php
ENV PHP_EXTRA_CONFIGURE_ARGS --with-apxs2

RUN mkdir -p $PHP_INI_DIR/conf.d

RUN curl -SL "http://php.net/get/php-$PHP_VERSION.tar.xz/from/this/mirror" -o php.tar.xz \
    && curl -SL "http://php.net/get/php-$PHP_VERSION.tar.xz.asc/from/this/mirror" -o php.tar.xz.asc \
	&& mkdir -p /usr/src/php \
	&& mkdir -p /usr/local/lib/php/extensions/no-debug-non-zts-20151012 \
	&& tar -xof php.tar.xz -C /usr/src/php --strip-components=1 \
	&& rm php.tar.xz* \
	&& cd /usr/src/php \
	&& ./configure \
		--with-config-file-path="$PHP_INI_DIR" \
		--with-config-file-scan-dir="$PHP_INI_DIR/conf.d" \
		$PHP_EXTRA_CONFIGURE_ARGS \
		--disable-cgi \
		--with-pgsql \
		--with-pdo-pgsql \
		--with-curl \
		--with-openssl \
		--with-pcre \
		--with-readline \
		--with-recode \
		--with-zlib \
		--with-gd \
		--with-mhash \
		--enable-mbstring \
		--with-pcre-regex \
		--enable-soap \
		--enable-zip \
		--with-gettext=shared \
		--with-libpng \
		--with-libjpeg \
		--with-jpeg-dir=/usr \
        --with-png-dir=/usr \
        --enable-gd-native-ttf \
        --enable-gd-jis-conv \
        --enable-geoip \
	&& make -j"$(nproc)" \
	&& make install \
	&& { find /usr/local/bin /usr/local/sbin -type f -executable -exec strip --strip-all '{}' + || true; } \
	&& apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $install \
	&& make clean \
	&& rm -rf /var/lib/apt/lists/*

########################################################################################################################
# INSTALL XDEBUG
########################################################################################################################
#RUN cd /tmp \
#	&& git clone https://github.com/xdebug/xdebug.git \
#	&& cd xdebug \
#	&& phpize \
#	&& ./configure \
#	--enable-xdebug \
#	&& make \
#	&& mkdir /usr/local/lib/php/extensions/no-debug-non-zts-20141001/ \
#	&& cp modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20141001/

########################################################################################################################
# INSTALL NODEJS && NPM
########################################################################################################################
RUN curl -sL https://deb.nodesource.com/setup | sudo bash -

RUN apt-get install -y nodejs --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN npm install -g bower grunt-cli
RUN gem install sass

########################################################################################################################
# INSTALL FFmpeg
########################################################################################################################
RUN add-apt-repository -y ppa:kirillshkrogalev/ffmpeg-next \
	&& apt-get update --force-yes \
	&& apt-get install -y ffmpeg

########################################################################################################################
# INSTALL GeoIP
########################################################################################################################
RUN mkdir -p /usr/local/share/GeoIP/ \
	&& wget -N http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz \
	&& gunzip GeoLiteCity.dat.gz \
	&& mv GeoLiteCity.dat /usr/local/share/GeoIP/

########################################################################################################################
# INSTALL let's encrypt
########################################################################################################################
RUN mkdir -p /var/lib/ \
	&& cd /var/lib/ \
	&& git clone https://github.com/letsencrypt/letsencrypt \
	&& cd letsencrypt \
	&& ./letsencrypt-auto --help

########################################################################################################################
# INITIALIZE
########################################################################################################################
COPY run /usr/local/bin/

WORKDIR /var/www/html

EXPOSE 80

CMD ["run"]