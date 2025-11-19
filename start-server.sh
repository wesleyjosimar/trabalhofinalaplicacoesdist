#!/bin/sh
cd /var/www/public
php -S 0.0.0.0:${PORT:-8000} ../public/index.php

