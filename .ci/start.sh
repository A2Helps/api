#!/bin/bash

# https://sipb.mit.edu/doc/safe-shell/
set -ef -o pipefail

# load nginx conf
cp /app/.ci/conf/nginx.conf /etc/nginx/nginx.conf
cp /app/.ci/conf/site.conf /etc/nginx/conf.d/site.conf
rm -f /etc/nginx/sites-available/default.conf
rm -f /etc/nginx/sites-available/default-ssl.conf

# load fpm conf
cp /app/.ci/conf/fpm.conf /usr/local/etc/php-fpm.conf
cp /app/.ci/conf/www.conf /usr/local/etc/php-fpm.d/www.conf
cp /app/.ci/conf/fpm.ini /usr/local/etc/php/conf.d/docker-vars.ini
rm -f /usr/local/etc/php-fpm.d/www.conf.default

mkdir -p /tmp/._spool/nginx/client_body_cache
chown -R nginx: /tmp/._spool/nginx

# Set the desired timezone
if [ -f /etc/TZ ]; then
  echo date.timezone=$(cat /etc/TZ) > /usr/local/etc/php/conf.d/timezone.ini
fi

if [ ! -z "$PUID" ]; then
  if [ -z "$PGID" ]; then
    PGID=${PUID}
  fi
  deluser nginx
  addgroup -g ${PGID} nginx
  adduser -D -S -h /var/cache/nginx -s /sbin/nologin -G nginx -u ${PUID} nginx
else
  if [ -z "$SKIP_CHOWN" ]; then
    echo "setting ownership"
    chown -Rf nginx.nginx /app
  fi
fi

# Run custom scripts
if [[ "$RUN_SCRIPTS" != "0" ]] ; then
  if [ -d "/app/.ci/scripts/" ]; then
    # make scripts executable incase they aren't
    chmod -Rf 750 /app/.ci/scripts; sync;
    # run scripts in number order
    for i in `ls /app/.ci/scripts/`; do /app/.ci/scripts/$i ; done
  else
    echo "Can't find script directory"
  fi
fi

# Start supervisord and services
exec /usr/bin/supervisord -n -c /etc/supervisord.conf

