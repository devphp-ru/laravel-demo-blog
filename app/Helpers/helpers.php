<?php

if (!function_exists('clearSearchBarFromCharacters')) {
    function clearSearchBarFromCharacters(string $string): string
    {
        $result = preg_replace('#[^0-9-a-zA-ZА-Яа-яёЁ@\.]#u', ' ', trim($string));
        $result = preg_replace('#\s+#u', ' ', $result);

        return mb_strtolower(trim($result));
    }

}
