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


const CONSUMER_KEY = TWITTER_CONSUMER_KEY;
const CONSUMER_SECRET = TWITTER_CONSUMER_SECRET;

/**
 * after user authorization for the application and redirecting to the script we are in now,
 * we receive an oauth_verifier that we should use to get a use access token , that is done in the following lines >>
 */
if (isset($_GET['oauth_verifier']))
{
    $oauth_verifier = $_GET["oauth_verifier"];
}else
{
    die('Error Authenticating user!');
}
//var_dump($_SESSION['oauth_token']);die();
if(!empty($_SESSION['twitter_oauth_token']) && !empty($_SESSION['twitter_token_secret']))
{
    $oauth_token = $_SESSION["twitter_oauth_token"];
    $token_secret = $_SESSION["twitter_token_secret"];
}
else
{
    die("not authorized!");
}


try{
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $token_secret);
}catch (\Abraham\TwitterOAuth\TwitterOAuthException $e){
    die($e->getMessage());
}

try{
    $response = $connection->oauth('oauth/access_token', array("oauth_verifier"=>$oauth_verifier));
}catch (\Abraham\TwitterOAuth\TwitterOAuthException $e){
    die($e->getMessage());
}

$_SESSION["twitter_user_token"] = $response['oauth_token'];
$_SESSION["twitter_user_token_secret"] = $response['oauth_token_secret'];


echo "You are Logged-in as !" . $response['screen_name'];
?>