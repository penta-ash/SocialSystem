<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/11/2016
 * Time: 8:59 AM
 */

require "Config/config.php";
require "DB/database.php";
//require "Includes/js_includes.php";

$db = new DB('localhost','pentates_socialsys0_1','pentates_ashraf','yX52xT;4$[IB');

if(!isset($_SESSION['login_token']))
{
    if (isset($_REQUEST['login']))
    {
        if(isset($_REQUEST['user_name']) && isset($_REQUEST['password']))
        {
            if (!empty($_REQUEST['user_name']) && !empty($_REQUEST['password']))
            {
                $password = md5($_REQUEST['password']);

                $_SESSION['user_name'] = $_REQUEST['user_name'];


                echo "<script>
                        var user_name = \"".$_SESSION['user_name']."\";

                        $(function(){
                            $('#user_name').val(user_name);
                        });
                      </script>";

                $user_signin = $db->user_signin('user_info',$_SESSION['user_name'], $password);

                if(!$user_signin['signin_status'])
                {
                    echo("<h5 style='color: red;'>Wrong user name or password.</br> Please Enter valid data or <a href='signup.php'>signup</a>!</h5><p/>");
                }
                else
                {
                    $login_token = bin2hex(openssl_random_pseudo_bytes(16));

                    $_SESSION['login_token'] = $login_token;

                    header("Location: http://penta-test.com/ashraf/SocialSystem-0.1/social_accounts.php");

                }
            }
            else
            {
                $_SESSION['user_name'] = $_REQUEST['user_name'];

                echo("<h5 style='color: red;'>please complete all of the fields!</h5><p/>");

                echo "<script>
                        var user_name = \"".$_SESSION['user_name']."\";

                        $(function(){
                            $('#user_name').val(user_name);
                        });
                      </script>";
            }
        }
    }
}
else
{
    header("Location: http://penta-test.com/ashraf/SocialSystem-0.1/social_accounts.php");
//    header("Refresh: 0;url=http://penta-test.com/ashraf/SocialSystem-0.1/social_accounts.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/styles.css">
    <meta charset="UTF-8">
    <title>Social System 0.1</title>
</head>

<body>
<div id="login-form">
    <h4>Welcome to SocialSys 0.1</h4>
    <form action="index.php" method="POST" enctype="application/x-www-form-urlencoded">
        User Name:</br>
        <input id="user_name" type="text" name="user_name" placeholder="enter your user name"><p/>

        Password:</br>
        <input id="password" type="password" name="password" placeholder="Enter your password"><p/>

        <input type="submit" name="login" value="Login">
    </form><p/>
    <a href="signup.php">create account</a>
</div>
</body>

</html>
