<?php
session_start();

function h($tag, $props = [], ...$children) {
    $attr = "";
    foreach ($props as $key => $value) {
        if ($key === "className") $key = "class";
        $attr .= " $key=\"" . htmlspecialchars($value) . "\"";
    }

    $html = "<$tag$attr>";
    foreach ($children as $child) {
        if (is_array($child)) {
            $html .= implode("", $child);
        } else {
            $html .= $child;
        }
    }
    $html .= "</$tag>";
    return $html;
}

function useState($key, $initial) {
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $initial;
    }

    $setState = function($value) use ($key) {
        $_SESSION[$key] = $value;
    };

    return [$_SESSION[$key], $setState];
}

function route($path) {
    return $_GET['route'] ?? '/';
}