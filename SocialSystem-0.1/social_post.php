<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/18/2016
 * Time: 1:04 PM
 */
require "DB/database.php";
require "Config/config.php";
require "facebook/post_to_fb.php";
require "twitter/post_to_twitter.php";
require "google/google_video_upload.php";

if(isset($_SESSION['login_token']) && !empty($_SESSION['login_token']))
{
    if(isset($_SESSION['facebook_user_accesstoken']) && !empty($_SESSION['facebook_user_accesstoken']) && isset($_SESSION['twitter_user_token']) && !empty($_SESSION['twitter_user_token']) && isset($_SESSION['google_user_token']) && !empty($_SESSION['google_user_token']))
    {
        // for sharing normal post
        if(isset($_REQUEST['post']))
        {
            if(isset($_REQUEST['post_content']) && !empty($_REQUEST['post_content']))
            {
                $fb_post = new FacebookPost();

                $fb_post_result = $fb_post->postToFacebook($_REQUEST['post_content'], $_SESSION['facebook_user_accesstoken']);

                $twitter_post = new TwitterPost();

                $twitter_post_result = $twitter_post->postToTwitter($_REQUEST['post_content'], $_SESSION['twitter_user_token'], $_SESSION['twitter_user_token_secret']);

                var_dump($fb_post_result);
                echo "<p/>";
                var_dump($twitter_post_result);
            }
        }


        // for uploading video
        if (isset($_REQUEST['video_upload_submit']))
        {
            if (isset($_REQUEST['video_title']) && !empty($_REQUEST['video_title']))
            {
                if (isset($_REQUEST['video_description']) && !empty($_REQUEST['video_description']))
                {
                    if (isset($_REQUEST['video_tags']) && !empty($_REQUEST['video_tags']))
                    {
                            if (isset($_FILES['video_file']) && !empty($_FILES['video_file']))
                            {
                                $allowed_video_types  = array("mp4", "avi", "mpeg", "mpg", "mov", "wmv", "rm");
                                $target_dir = __DIR__.'/google/videos_to_upload/';
                                $target_video = $target_dir . str_shuffle('123abcdxyz').'-'.basename($_FILES['video_file']['name']);
                                $upload_ok = 1;
                                $video_file_type = pathinfo($target_video, PATHINFO_EXTENSION);


                                if (in_array($video_file_type, $allowed_video_types))
                                {

                                    if (file_exists($target_video))
                                    {
                                        $upload_ok = 0;
                                        die("sorry file already exists");
                                    }
                                    else
                                    {
                                        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_video))
                                        {
                                            $video_to_upload_path = $target_video;
                                            $youtube_upload_video = new GoogleVideoUpload();
                                            $youtube_upload_video_result = $youtube_upload_video->upload_youtube_video($_REQUEST['video_title'], $_REQUEST['video_description'], $video_to_upload_path, $_REQUEST['video_tags']);

                                            var_dump($youtube_upload_video_result);

                                            if($youtube_upload_video_result == "uploaded")
                                            {
                                                unlink($video_to_upload_path);
                                            }
                                            else
                                            {
                                                echo "<h4 style='color: red;'>Error uploading video to youtube, please try again later.</h4>";
                                            }
                                        }
                                        else
                                        {
                                            die ("Error uploading video, please try again later!");
                                        }
                                    }
                                }
                                else
                                {
                                    $upload_ok = 0;
                                    die("only video with". implode(',', $allowed_video_types) . " extensions can be uploaded");
                                }
                            }
                            else
                            {
//                            var_dump($_FILES);
                                echo "<h4 style='color:red'>please provide video path to upload</h4>";
                            }
                    }
                    else
                    {
                        echo "<h4 style='color:red'>please provide video tags</h4>";
                    }
                }
                else
                {
                    echo "<h4 style='color:red'>please provide a video description</h4>";
                }
            }
            else
            {
                echo "<h4 style='color:red'>please provide a video title</h4>";
            }
        }
    }
    else
    {
        die("<h4>Please <a href='social_accounts.php'>login</a> with social accounts first!</h4>");
    }
}
else
{
    die("<h4>Please <a href='index.php'>login</a> first!</h4>");
}



require "Includes/js_includes.php";
?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="styles/styles.css">
    <title>Social Posting</title>
</head>
<div>
    <a href="logout.php">logout</a>
</div><p/>
    <textarea rows="4" cols="50" name="post_content" form="social-posting-form" placeholder="Write your post here"></textarea><p/>
    <form id="social-posting-form" method="POST" action="social_post.php" enctype="application/x-www-form-urlencoded">
        <input type="submit" name="post" value="Post" id="post-submit">
    </form><p/>
<h3>OR .. Upload video</h3><p/>
<form id="upload_video_form" method="post" action="social_post.php" enctype="multipart/form-data">
    <label for="video_title_id">Title:</label>
    <input type="text" name="video_title" id="video_title_id" placeholder="Enter video title here"><p/>
    <label for="video_description_id">Description:</label>
    <input type="text" name="video_description" id="video_description_id" placeholder="Enter video description here"><p/>
    <label for="video_tags_id">Tags:</label>
    <input type="text" name="video_tags" id="video_tags_id" placeholder="Enter video tags here"><p/>
    <label for="video_file_id">Choose Video:</label>
    <input type="file" name="video_file" id="video_file_id" placeholder="Choose video to upload"><p/>
    <p/>
    <input type="submit" name="video_upload_submit" id="video_upload_submit_id" value="Upload Video">
</form>
</body>
</html>

