<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/17/2016
 * Time: 2:43 PM
 */
require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;
require "../Config/config.php";


//getting outh token and token secret --

const CONSUMER_KEY = TWITTER_CONSUMER_KEY;
const CONSUMER_SECRET = TWITTER_CONSUMER_SECRET;

try{
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
}catch (\Abraham\TwitterOAuth\TwitterOAuthException $e){
    die($e->getMessage());
}

try{
    $request_token = $connection->oauth("oauth/request_token", array("oauth_callback"=> TWITTER_CALLBACK_URI));
}catch (\Abraham\TwitterOAuth\TwitterOAuthException $e){
    die($e->getMessage());
}

//var_dump(json_encode($request_token));

$oauth_token = $request_token['oauth_token'];
$token_secret = $request_token['oauth_token_secret'];

$_SESSION["twitter_oauth_token"]= $oauth_token;
$_SESSION["twitter_token_secret"] = $token_secret;

// authorizing user --

$url = $connection->url("oauth/authorize", array("oauth_token" => $oauth_token));

header("Location: $url");
?>