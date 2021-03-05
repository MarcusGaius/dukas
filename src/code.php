<?php

if (!isset($_SESSION['access_token'])) {
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect_uri = $client->helper()->url('?start');
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
