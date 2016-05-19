<?php
/**
 * Created by PhpStorm.
 * User: Ash
 * Date: 4/12/2016
 * Time: 2:13 PM
 */

require_once './vendor/autoload.php';
require "./Config/config.php";

class FacebookPost
{
    public function postToFacebook($message, $fb_token)
    {
        $fb_service = new \Facebook\Facebook([
            'app_id'=> FACEBOOK_APP_ID,
            'app_secret'=> FACEBOOK_APP_SECRET,
            'default_graph_version' => FACEBOOK_API_VERSION,
        ]);

        $data = [
            'message' => $message,
        ];

        try{
            $response = $fb_service->post('/me/feed', $data, $fb_token);
//            $response = $fb_service->post('/me/photos', $data, $_SESSION["facebook_user_accesstoken"]);
        }catch (\Facebook\Exceptions\FacebookSDKException $e){
            die($e->getMessage());
        }catch (\Facebook\Exceptions\FacebookResponseException $e){
            die($e->getMessage());
        }

        return array('fb_status'=>'ok', 'post_id'=>$response->getGraphNode()['id']);
    }
}
?>