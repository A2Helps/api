#!/usr/bin/env bash

# https://sipb.mit.edu/doc/safe-shell/
set -euf -o pipefail

su -s /bin/bash -c "cd /app; php artisan config:cache" nginx
