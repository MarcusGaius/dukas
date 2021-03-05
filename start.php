<?php

session_start();
$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['PHP_SELF'])['dirname'] . '/?replace=true';

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) header('Location: ' . filter_var(str_replace('replace', 'report', $url), FILTER_SANITIZE_URL));
else header('Location: ' . filter_var(str_replace('replace', 'auth', $url), FILTER_SANITIZE_URL));
