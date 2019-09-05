```
server {
    listen              80;

    server_name         gatehouse.local;

    access_log          /var/log/nginx/_gatehouse.access.log    main;
    error_log           /var/log/nginx/_gatehouse.error.log     info;

    root                /var/www/gatehouse/www/;
    index               index.php;

    set                 $fpm_name       "/index.php";

    location = /favicon.ico {
        access_log      off;
        log_not_found   off;
    }

    location / {
        try_files       $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include         fastcgi_params;
        set             $script_name $fastcgi_script_name;
        include         fastcgi_proxy;
    }
}

```