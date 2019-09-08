```
server {
    listen              80;

    server_name         gatekeeper.wintersky.me;

    access_log          /var/log/nginx/gatekeeper.access.log;
    error_log           /var/log/nginx/gatekeeper.error.log     info;

    root                /var/www/gatekeeper/;
    index               index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass php-handler-7-2;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME /var/www/gatekeeper$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ favicon.* {
        access_log      off;
        log_not_found   off;
    }

    location ~ /_ {
        deny all;
    }
}

```