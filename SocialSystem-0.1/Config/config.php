<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/11/2016
 * Time: 8:58 AM
 */
ob_start();
session_start();

// facebook config
define('FACEBOOK_APP_ID', '231814280503812');
define('FACEBOOK_APP_SECRET', '55e8ef3d451e63c9dbbdb9c9c90c6eba');
define('FACEBOOK_API_VERSION', 'v2.6');
define('FACEBOOK_CALLBACK_URI', 'http://penta-test.com/ashraf/SocialSystem-0.1/facebook/facebook_login_callback.php');

// twitter keconfigys
define('TWITTER_CONSUMER_KEY', '1tfag6CnRuGVoG0NBGGFfPan3');
define('TWITTER_CONSUMER_SECRET', 'rhatRJmRTjzDgHn65YuQVmxOarv5ql3cja4QZPeUMKWs0PddEW');
define('TWITTER_CALLBACK_URI', 'http://penta-test.com/ashraf/SocialSystem-0.1/twitter/twitter_login_callback.php');

// google config
define('GOOGLE_CLIENT_ID', '623491951625-ve38ceq0llvpsda0avfn26phkem6bhtu.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'KQ7CvSn5XbbWhmIdCrpKtCNa');
define('GOOGLE_REDIRECT_URI', 'http://penta-test.com/ashraf/SocialSystem-0.1/google/google_login_callback.php');
?>