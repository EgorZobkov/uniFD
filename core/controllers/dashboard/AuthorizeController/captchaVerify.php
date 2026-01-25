public function captchaVerify()
{   
    $codes = $this->session->get("captcha");
    if(isset($codes)){
        if(empty($_POST['code'])){
            return json_answer(["status"=>false, "answer"=>translate("tr_74ae10c77013a9fdccd7268e9a9d1328")]);
        }else{
            if(in_array($_POST['code'], $codes)){
                $this->session->delete("captcha");
                $this->session->delete("dashboard-login-attempts");
                $this->session->delete("dashboard-login-forgot-attempts");
                return json_answer(["status"=>true]);
            }else{
                return json_answer(["status"=>false, "answer"=>translate("tr_f3d36dc0151f78dc12e1d428a4c5f599")]);
            }
        }
    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_b033c1aed3f5073873e0d02f5af7abed")]);
    }
}