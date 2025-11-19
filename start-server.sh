#!/bin/sh
cd /var/www
php -S 0.0.0.0:${PORT:-8000} -t public public/index.php

