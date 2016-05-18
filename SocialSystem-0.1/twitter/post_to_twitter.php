<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 4/26/2016
 * Time: 1:53 PM
 */

require_once './vendor/autoload.php';
require "./Config/config.php";
use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterPost
{
    public function postToTwitter($message, $twitter_token, $twitter_token_secret)
    {
        try
        {
            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $twitter_token, $twitter_token_secret);
        }catch (\Abraham\TwitterOAuth\TwitterOAuthException $e)
        {
            die($e->getMessage());
        }

        $data = array('status'=>$message);
        $post_action = $connection->post('statuses/update', $data);

        return $post_action;
    }
}
?>