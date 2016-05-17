<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/11/2016
 * Time: 8:58 AM
 */

session_start();

// facebook constants
define('FACEBOOK_APP_ID', '231814280503812');
define('FACEBOOK_APP_SECRET', '55e8ef3d451e63c9dbbdb9c9c90c6eba');
define('FACEBOOK_API_VERSION', 'v2.6');
define('FACEBOOK_CALLBACK_URI', 'http://localhost/SocialSystem-0.1/facebook/facebook_login_callback.php');

// twitter constants
define('TWITTER_CONSUMER_KEY', '1tfag6CnRuGVoG0NBGGFfPan3');
define('TWITTER_CONSUMER_SECRET', 'rhatRJmRTjzDgHn65YuQVmxOarv5ql3cja4QZPeUMKWs0PddEW');
define('TWITTER_CALLBACK_URI', 'http://127.0.0.1/SocialSystem-0.1/twitter/twitter_login_callback.php');

?>