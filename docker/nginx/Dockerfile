#FROM lexaguskov/freebsd:latest
#
##RUN pkg install -y nginx

FROM openresty/openresty:xenial

RUN apt-get -y update --fix-missing

# Image Magick
RUN apt-get install -y \
  build-essential checkinstall libx11-dev libxext-dev zlib1g-dev libpng12-dev libjpeg-dev libfreetype6-dev libxml2-dev --fix-missing

#RUN apt-get build-dep -y imagemagick
RUN apt-get install -y curl wget

# WEBP format
RUN apt-get install -y libwebp-dev devscripts

#RUN wget http://www.imagemagick.org/download/releases/ImageMagick-6.8.9-10.tar.bz2
RUN wget http://www.imagemagick.org/download/releases/ImageMagick-7.0.10-29.tar.xz
RUN tar xf ImageMagick-7.0.10-29.tar.xz
RUN cd ImageMagick-7.0.10-29 && ./configure --prefix=/usr --with-webp && make && make install

RUN apt-get install -y tcpdump htop

# Debug
RUN apt-get install -y curl wget htop

# Build
RUN apt-get install -y \
  wget build-essential autoconf automake pkg-config libssl-dev openssl libxslt-dev

# Lib RSVG
RUN apt-get install -y librsvg2-2
RUN apt-get install -y librsvg2-bin

# Lua
RUN apt-get install -y lua5.3

#RUN luarocks install luasocket --from=http://luarocks.logiceditor.com/rocks/
#RUN luarocks install magick   --from=http://luarocks.logiceditor.com/rocks/