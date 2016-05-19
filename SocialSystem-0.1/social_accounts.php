<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/17/2016
 * Time: 1:44 PM
 */
require "Config/config.php";
require "DB/database.php";
require "Includes/js_includes.php";


if(isset($_SESSION['facebook_loggedin']) && isset($_SESSION['twitter_loggedin']))
{
    if ($_SESSION['facebook_loggedin'] == true && $_SESSION['twitter_loggedin'] == true && $_SESSION['google_logged_in'] == true)
    {
        header("Location: http://penta-test.com/ashraf/SocialSystem-0.1/social_post.php");
    }
}

if (isset($_SESSION['login_token']) && !empty($_SESSION['login_token']))
{
    if (isset($_SESSION['facebook_user_accesstoken']) && !empty($_SESSION['facebook_user_accesstoken']))
    {
        echo "
            <script>
                $(function(){
                    $('#fb_login').css({'display':'none'});
                });
            </script>
        ";
    }

    if(isset($_SESSION['twitter_user_token']) && !empty($_SESSION['twitter_user_token']))
    {
        echo "
            <script>
                $(function(){
                    $('#twitter_login').css({'display':'none'});
                });
            </script>
        ";
    }

    if(isset($_SESSION['google_user_token']) && !empty($_SESSION['google_user_token']))
    {
        echo "
            <script>
                $(function(){
                    $('#google_login').css({'display':'none'});
                });
            </script>
        ";
    }


}
else
{
    die("Please <a href='index.php'>login</a> first!");
}

?>

<a href="logout.php">logout</a><p/>
<div>
    <button id="fb_login" type="button" name="facebook_login"><a href="facebook/facebook_login.php">Facebook Login</a></button>
    <button id="twitter_login" type="button" name="twitter_login"><a href="twitter/twitter_login.php">Twitter Login</a></button>
    <button id="google_login" type="button" name="google_login"><a href="google/google_login.php">Google Login</a></button>

</div>

