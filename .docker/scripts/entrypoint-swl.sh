#!/usr/bin/env sh
printf "\n\nStarting Supervisor...\n\n";
php /var/www/localhost/htdocs/artisan optimize:clear
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf
