<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/19/2016
 * Time: 9:43 AM
 */

require_once "../vendor/autoload.php";
require "../Config/config.php";

if(isset($_SESSION['login_token']) && !empty($_SESSION['login_token']))
{

    if (isset($_GET['code']) && !empty($_GET['code']))
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

        if (!$client->authenticate($_GET['code']))
        {
            die("Error during authentication, please try again later.  <a href='../index.php'>Back</a>!");
        }
        else
        {


            try
            {
                $token = $client->getAccessToken();
                $client->setAccessToken($token);

                $_SESSION['google_user_token'] = $token;
                $_SESSION['google_logged_in'] = true;

                header("Location: http://penta-test.com/ashraf/SocialSystem-0.1/social_accounts.php");
            }
            catch (Google_Exception $e)
            {
                die("Google Exception: ".$e->getMessage());
            }
        }
    }
    else
    {
        die("Error during authentication, please try again later.  <a href='../index.php'>Back</a>!");
    }
}
else
{
    die("Please <a href='../index.php'>login</a> first!");
}

?>