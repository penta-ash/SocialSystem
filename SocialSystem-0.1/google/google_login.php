<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/19/2016
 * Time: 9:43 AM
 */
require_once "../vendor/autoload.php";
require "../Config/config.php";

$scopes = ['https://www.googleapis.com/auth/youtube'];

if (isset($_SESSION['login_token']) && !empty($_SESSION['login_token']))
{
    $scopes = $scopes = ['https://www.googleapis.com/auth/plus.login',
        'https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/userinfo.email',
        'https://www.googleapis.com/auth/userinfo.profile',
        'https://www.googleapis.com/auth/plus.stream.write',
        'https://www.googleapis.com/auth/youtube'];

    $client = new Google_Client();
    $client->setScopes($scopes);
    $client->setClientId(GOOGLE_CLIENT_ID);
    $client->setClientSecret(GOOGLE_CLIENT_SECRET);
    $client->setRedirectUri(GOOGLE_REDIRECT_URI);

    $auth_url = $client->createAuthUrl();

    header("Location:".filter_var($auth_url, FILTER_SANITIZE_URL));
}
else
{
    die("Please <a href='../index.php'>login</a> first!");
}

?>