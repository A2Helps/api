#!/bin/bash

# https://sipb.mit.edu/doc/safe-shell/
set -euf -o pipefail

cd /app
chown -Rf nginx.nginx /app
chmod 750 /app/.ci/start.sh

#
# Versioning
#
git describe --tags > version.txt || echo 'hot' > version.txt

#
# Build
#
composer global require hirak/prestissimo
composer --no-ansi --no-interaction install --no-suggest --no-progress --no-dev --working-dir=/app

php artisan optimize
php artisan route:cache
php artisan event:cache
php artisan config:clear # we will cache config on container start
