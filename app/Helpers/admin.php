<?php

if (!function_exists('dt_admin_contains_any')) {
    function dt_admin_contains_any($string, $substrings) {
        foreach ($substrings as $match) {
            if (strpos($string, $match) >= 0) {
                // A match has been found, return true
                return true;
            }
        }

        // No match has been found, return false
        return false;
    }
}