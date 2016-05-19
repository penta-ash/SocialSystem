<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 5/19/2016
 * Time: 9:44 AM
 */
require "./vendor/autoload.php";
require "./Config/config.php";

class GoogleVideoUpload
{
    public function upload_youtube_video($video_title, $video_description, $video_path, $video_tags)
    {
        $result = "";
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

        $client->setAccessToken($_SESSION['google_user_token']);

        try
        {
            $youtube = new Google_Service_YouTube($client);

            if(is_string($video_tags))
            {
                $video_tags = explode(',', $video_tags);
            }
            else
            {
                die("please provide string of tags delimited with ','");
            }

            $path_to_video_to_upload = $video_path;

            // Get the Mimetype of your video
//            $finfo = finfo_open(FILEINFO_MIME_TYPE);
//            $mime_type = finfo_file($finfo, $path_to_video_to_upload);

            // Build the Needed Video Information
            $snippet = new Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle($video_title);
            $snippet->setDescription($video_description);
            $snippet->setTags($video_tags);
            $snippet->setCategoryId(22);

            // Build the Needed video Status
            $status = new Google_Service_YouTube_VideoStatus();
            $status->setPrivacyStatus("public"); // or public, unlisted

            // Set the Video Info and Status in the Main Tag
            $video = new Google_Service_YouTube_Video();
            $video->setSnippet($snippet);
            $video->setStatus($status);

            // Send the video to the Google Youtube API
            $created_file = $youtube->videos->insert('snippet,status', $video, array(
                'data' => file_get_contents($path_to_video_to_upload)
//                'mimeType' => $mime_type,
            ));

            // Get the information of the uploaded video
              $result = $created_file;
        }
        catch (Exception $e)
        {
            die("Uploading Video Exception: ".$e);
        }

        return $result->getStatus()->uploadStatus;
    }
}


//if(isset($_SESSION['login_token']) && !empty($_SESSION['login_token']))
//{
//    if (isset($_SESSION['google_user_token']) && !empty($_SESSION['google_user_token']))
//    {
//
//    }
//    else
//    {
//        die("Please <a href='google_login.php'>authenticate your account</a> first!");
//    }
//}
//else
//{
//    die("Please <a href='../index.php'>login</a> first!");
//}

?>