public function sendMessageFirebase($params = []){
    global $app;

    if(!$app->settings->api_app_firebase_push_params || !$params['token']) return false;

    try {

        $data = _json_decode(decrypt($app->settings->api_app_firebase_push_params));

        if(strtotime($app->settings->api_app_firebase_bearer_expires_in) <= time() || !$app->settings->api_app_firebase_bearer_expires_in){

            $client = new \Google\Client();

            $client->setAuthConfig($data);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            $token = $client->getAccessToken();

            if($token['access_token']){

                $app->model->settings->update(date('Y-m-d H:i:s', intval($token['created'])+intval($token['expires_in'])),"api_app_firebase_bearer_expires_in");
                $app->model->settings->update(encrypt($token['access_token']),"api_app_firebase_bearer");
                $fbm_bearer = $token['access_token'];

            }else{
                logger("Firebase: ".print_r($token, true));
                return false;
            }

        }else{
            $fbm_bearer = decrypt($app->settings->api_app_firebase_bearer);
        }

        $ch = curl_init();

        $headers = array(
            'Authorization: Bearer '.$fbm_bearer,
            'Content-Type: application/json'
        );

        $body = [
            'message' => [
               'token' => $params['token'],
               'notification' => [
                    "title" => (String)$params['title'],
                    "body" => (String)$params['text'],
               ],
               'data' => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "screen" => $params['screen'] ? (String)$params['screen'] : 'chat',
                    "dialogue_token" => $params['dialogue_token'] ? (String)$params['dialogue_token'] : null,
                    "whom_user_id" => $params['whom_user_id'] ? (String)$params['whom_user_id'] : null,
                    "from_user_id" => $params['from_user_id'] ? (String)$params['from_user_id'] : null,
                    "channel_id" => $params['channel_id'] ? (String)$params['channel_id'] : null,
                    "ad_id" => $params['ad_id'] ? (String)$params['ad_id'] : null,
                ],
                "android" => [
                    "notification" => [
                        "sound" => "default",
                    ],
                    "priority" => "high",
                ],    
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => "default",
                        ],
                    ]
                ],
            ],
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$data["project_id"]}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, _json_encode($body));

        $answer = _json_decode(curl_exec($ch));

        curl_close($ch);

        if(empty($answer['error'])){
            return true;
        }else{
            logger("Firebase: ".print_r($answer['error'], true));
            return false;
        }

    } catch (Exception $e) {
        logger("Firebase: {$e->getMessage()}");
        return false;
    }
 
}