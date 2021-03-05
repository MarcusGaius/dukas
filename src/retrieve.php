<?php

$client->setRedirectUri($client->helper()->url());
$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));