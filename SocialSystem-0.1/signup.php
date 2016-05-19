<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/11/2016
 * Time: 11:32 AM
 */
require "Config/config.php";
require "DB/database.php";
require "Includes/js_includes.php";


$db = new DB('localhost','pentates_socialsys0_1','pentates_ashraf','yX52xT;4$[IB');

if(!isset($_SESSION["login_token"]))
{
    if(isset($_REQUEST['signup']))
    {
        if (isset($_REQUEST['user_name']) && isset($_REQUEST['email']) && isset($_REQUEST['password']) && isset($_REQUEST['password_confirm']))
        {
            if (!empty($_REQUEST['user_name']) && !empty($_REQUEST['email']) && !empty($_REQUEST['password']) && !empty($_REQUEST['password_confirm']))
            {

                // encrypting passwords for security reasons
                $_REQUEST['password'] = md5($_REQUEST['password']);
                $_REQUEST['password_confirm'] = md5($_REQUEST['password_confirm']);


                if ($_REQUEST['password'] === $_REQUEST['password_confirm'])
                {
                    $_SESSION['signup_username'] = $_REQUEST['user_name'];
                    $_SESSION['signup_email'] = $_REQUEST['email'];

                    echo "<script>
                            var username = \"".$_SESSION['signup_username']."\";
                            var email = \"".$_SESSION['signup_email']."\";

                            $(function(){
                            $('#user_name').val(username);
                            $('#email').val(email);
                            });
                        </script>";

                    // check if user already signedup.
                    $select_user = $db->select_user('user_info',$_SESSION['signup_username']);

                    if(!$select_user['select_status'])
                    {
                        die("<h5 style='color: red;'>Signup Error:</h5> ".$select_user['select_result']."<a href='signup.php'>Back!</a>");
                    }
                    elseif ($select_user['select_result'] != null)
                    {
                        $_SESSION['signup_username'] = "";
                        $_SESSION['signup_email'] = "";
                        die("<h4 style='color: darkgreen;'>You already signed up!</h4><p/>"."<a href='index.php'>Signin!</a>");
                    }


                    // insert signed up user into database if not already signed up
                    $insert_user = $db->insert('user_info',array('user_name','email','password'), array($_SESSION['signup_username'], $_SESSION['signup_email'], $_REQUEST['password']));

                    if(!$insert_user['insert_status'])
                    {
                        // if insert into database returns error the process is blocked with error
                        die("<h5 style='color: red;'>Signup Error:</h5> ".$insert_user['error']."<a href='signup.php'>Back!</a>");
                    }
                    else
                    {
                        // if insert into database is done, user can go to signin page
                        echo "<h4 style='color: darkgreen;'>You signed up successfully, now ou can <a href='index.php'>Login!</a></h4>";
                        $_SESSION['signup_username'] = "";
                        $_SESSION['signup_email'] = "";
                    }
                }
                else
                {
                    $_SESSION['signup_username'] = $_REQUEST['user_name'];
                    $_SESSION['signup_email'] = $_REQUEST['email'];

                    echo("<h5 style='color: red;'>passwords didn't match!</h5><p/>");
                    echo "<script>
                            var username = \"".$_SESSION['signup_username']."\";
                            var email = \"".$_SESSION['signup_email']."\";
                            $(function(){
                            $('#user_name').val(username);
                            $('#email').val(email);
                            });
                        </script>";

                }
            }
            else
            {
                $_SESSION['signup_username'] = $_REQUEST['user_name'];
                $_SESSION['signup_email'] = $_REQUEST['email'];


                echo("<h5 style='color: red;'>please complete all of the fields!</h5><p/>");
                echo "<script>
                            var username = \"".$_SESSION['signup_username']."\";
                            var email = \"".$_SESSION['signup_email']."\";

                            $(function(){
                            $('#user_name').val(username);
                            $('#email').val(email);
                            });
                        </script>";
            }
        }
    }

}
else
{
    header("Location: http://penta-test.com/ashraf/SocialSystem-0.1/index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/styles.css">
    <title>Signup</title>
</head>
<body id="signup-form">
<h4>Signup</h4>
<form action="signup.php" method="POST" enctype="application/x-www-form-urlencoded">
    User Name:</br>
    <input id="user_name" type="text" name="user_name" placeholder="Enter Your new user name"><p/>

    Email:</br>
    <input id="email" type="email" name="email" placeholder="Enter a valid email"><p/>

    Password:</br>
    <input id="password" type="password" name="password" placeholder="Enter your password"><p/>

    Confirm Password:</br>
    <input id="password_confirm" type="password" name="password_confirm" placeholder="re-enter your password"><p/>

    <input type="submit" name="signup" value="Signup">
</form>
</body>
</html>
