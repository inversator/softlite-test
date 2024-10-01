FROM laravel/sail:latest

COPY . .
COPY init.sh /var/www/html/init.sh
RUN chmod +x /var/www/html/init.sh
