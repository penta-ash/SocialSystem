<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/17/2016
 * Time: 2:22 PM
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
    $permissions = ['public_profile', 'user_posts', 'publish_actions', 'manage_pages', 'publish_pages', 'read_page_mailboxes'];
    $loginUrl = $helper->getLoginUrl(FACEBOOK_CALLBACK_URI, $permissions);


    header("Location: $loginUrl");
}
else
{
    die("Please <a href='../index.php'>login</a> first!");
}

?>