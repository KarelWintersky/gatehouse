<?php

if (!function_exists('http_redirect')) {
    function http_redirect($uri, $replace_prev_headers = false, $code = 302)
    {
        $default_scheme = getenv('REDIRECT_DEFAULT_SCHEME') ?: 'http://';
        if (strstr($uri, "http://") or strstr($uri, "https://")) {
            header("Location: " . $uri, $replace_prev_headers, $code);
        } else {
            header("Location: {$default_scheme}{$_SERVER['HTTP_HOST']}{$uri}", $replace_prev_headers, $code);
        }
        exit(0);
    }
}