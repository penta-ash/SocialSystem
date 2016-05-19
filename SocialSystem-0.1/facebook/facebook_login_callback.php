<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/17/2016
 * Time: 2:26 PM
 */
require_once '../vendor/autoload.php';
require "../Config/config.php";


if(isset($_SESSION['login_token']) && !empty($_SESSION['login_token']))
{

    $fb_service = new \Facebook\Facebook([
        'app_id'=> FACEBOOK_APP_ID,
        'app_secret'=> FACEBOOK_APP_SECRET,
        'default_graph_version' => FACEBOOK_API_VERSION,
    ]);

    $helper = $fb_service->getRedirectLoginHelper();

    try{
        $token = $helper->getAccessToken();
    }catch(\Facebook\Exceptions\FacebookSDKException $e){
        echo "Facebook SDK returned error: ". $e->getMessage();
        exit();
    }catch(\Facebook\Exceptions\FacebookResponseException $e){
        echo "Facebook Graph API returned error: ". $e->getMessage();
        exit();
    }

    if(!isset($token)){
        if($helper->getError()){
            header("HTTP/1.0 401 Unauthorized");
            echo 'ERROR: '.$helper->getError().'\n';
            echo 'ERROR CODE: '.$helper->getErrorCode().'\n';
            echo "ERROR REASON: ".$helper->getErrorReason().'\n';
            echo "ERROR DESCRIPTION".$helper->getErrorDescription().'\n';
        }else{
            header("HTTP/1.0 400 Bad Request");
            echo "Bad Request!";
        }
        exit();
    }elseif (isset($token)){
        if(!$token->isExpired()){
            if (!$token->isLongLived()){
                try{
                    $oAuth2Client = $fb_service->getOAuth2Client();
                    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken((string)$token);
                    $token = $longLivedAccessToken;
                }catch (\Facebook\Exceptions\FacebookSDKException $e){
                    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                    exit;
                }

            }

            $_SESSION["facebook_user_accesstoken"] = (string)$token;
            $fb_service->setDefaultAccessToken($_SESSION["facebook_user_accesstoken"]);

//        if ((string)$token === (string)$_SESSION["facebook_user_accesstoken"]){
//            echo "equaled tokens\n\n";
//        }else{
//            echo "session token: ".$_SESSION["facebook_user_accesstoken"]."\n\n";
//            echo "new token: ".$token."\n\n";
//        }

            makeFacebookRequest($fb_service);

        }else{
            die("Expired Access Token!");
        }

    }
}
else
{
    die("Please <a href='../index.php'>login</a> first!");
}

function makeFacebookRequest($fb){
    try{
        $response = $fb->get('/me');
        $userNode = $response->getGraphUser();
    }catch (\Facebook\Exceptions\FacebookResponseException $e){
        die($e->getMessage());
    }catch (\Facebook\Exceptions\FacebookSDKException $e){
        die($e->getMessage());
    }
    $_SESSION['facebook_loggedin'] = true;
    header("Location: http://penta-test.com/ashraf/SocialSystem-0.1/social_accounts.php");
}

?>