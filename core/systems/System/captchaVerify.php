public function captchaVerify($code, $captcha_id=null){   
    global $app;

    $codes = $app->session->get("captcha");

    if(isset($codes)){
        if(empty($code)){
            return ["status"=>false, "answer"=>translate("tr_74ae10c77013a9fdccd7268e9a9d1328")];
        }else{
            if(in_array($code, $codes)){
                $app->session->delete("captcha");
                $app->session->delete($captcha_id);
                return ["status"=>true];
            }else{
                return ["status"=>false, "answer"=>translate("tr_f3d36dc0151f78dc12e1d428a4c5f599")];
            }
        }
    }else{
        return ["status"=>false, "answer"=>translate("tr_b033c1aed3f5073873e0d02f5af7abed")];
    }
}