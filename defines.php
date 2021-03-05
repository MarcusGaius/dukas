<?php

define('PATH', __DIR__ . '/');
define('URI', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . pathinfo($_SERVER['PHP_SELF'])['dirname'] . '/');
