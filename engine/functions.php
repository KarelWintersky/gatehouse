<?php

if (!function_exists('http_redirect')) {
    function http_redirect($uri, $replace_prev_headers = false, $code = 302)
    {
        $default_scheme = getenv('REDIRECT_DEFAULT_SCHEME') ?: 'http://';
        if (strstr($uri, "http://") || strstr($uri, "https://")) {
            header("Location: " . $uri, $replace_prev_headers, $code);
        } else {
            header("Location: {$default_scheme}{$_SERVER['HTTP_HOST']}{$uri}", $replace_prev_headers, $code);
        }
        exit(0);
    }
}

if (!function_exists('translate_transport_number')) {
    function translate_transport_number($str)
    {
        //  а, в, е, к, м, н, о, р, с, т, у, х
        //  =>
        //  a, b, e, k, m, h, o, p, с, t, y, x
        // аналогично с верхним регистром
        // То что транслитерируется - транслитерировать заменой. И перевести все в UpperCase
        // Что не - оставить
        $str = mb_strtoupper($str);

        if (getenv('TRANSPORT_TRANSLATE_NUMBER') == 1) {
            $from   = [ 'А', 'В', 'Е', 'К', 'М', 'Н', 'О', 'Р', 'С', 'Т', 'У', 'Х']; // русские буквы
            $to     = [ 'A', 'B', 'E', 'K', 'M', 'H', 'O', 'P', 'C', 'T', 'Y', 'X']; // латинские буквы

            $str = str_replace($from, $to, $str);
        }
        return $str;
    }
}