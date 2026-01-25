<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\OAuth;

class Vkontakte{

    public $alias = "vkontakte";
    public $data;

    public function __construct(){
        global $app;
        $this->data = $this->getData();
    }

    public function getData(){
        global $app;
        $data = $app->model->system_oauth_services->find("alias=?", [$this->alias]);
        if($data){
            $data->params = (object)_json_decode(decrypt($data->params));
            return $data;
        }
    }

    public function logo(){
        global $app;

        if(!$app->storage->name($this->data->image)->exist()){
            return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGlkPSJDYXBhXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDExMi4xOTYgMTEyLjE5NjsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDExMi4xOTYgMTEyLjE5NiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PGc+PGNpcmNsZSBjeD0iNTYuMDk4IiBjeT0iNTYuMDk4IiBpZD0iWE1MSURfMTFfIiByPSI1Ni4wOTgiIHN0eWxlPSJmaWxsOiM0RDc2QTE7Ii8+PC9nPjxwYXRoIGQ9Ik01My45NzksODAuNzAyaDQuNDAzYzAsMCwxLjMzLTAuMTQ2LDIuMDA5LTAuODc4ICAgYzAuNjI1LTAuNjcyLDAuNjA1LTEuOTM0LDAuNjA1LTEuOTM0cy0wLjA4Ni01LjkwOCwyLjY1Ni02Ljc3OGMyLjcwMy0wLjg1Nyw2LjE3NCw1LjcxLDkuODUzLDguMjM1ICAgYzIuNzgyLDEuOTExLDQuODk2LDEuNDkyLDQuODk2LDEuNDkybDkuODM3LTAuMTM3YzAsMCw1LjE0Ni0wLjMxNywyLjcwNi00LjM2M2MtMC4yLTAuMzMxLTEuNDIxLTIuOTkzLTcuMzE0LTguNDYzICAgYy02LjE2OC01LjcyNS01LjM0Mi00Ljc5OSwyLjA4OC0xNC43MDJjNC41MjUtNi4wMzEsNi4zMzQtOS43MTMsNS43NjktMTEuMjljLTAuNTM5LTEuNTAyLTMuODY3LTEuMTA1LTMuODY3LTEuMTA1bC0xMS4wNzYsMC4wNjkgICBjMCwwLTAuODIxLTAuMTEyLTEuNDMsMC4yNTJjLTAuNTk1LDAuMzU3LTAuOTc4LDEuMTg5LTAuOTc4LDEuMTg5cy0xLjc1Myw0LjY2Ny00LjA5MSw4LjYzNmMtNC45MzIsOC4zNzUtNi45MDQsOC44MTctNy43MSw4LjI5NyAgIGMtMS44NzUtMS4yMTItMS40MDctNC44NjktMS40MDctNy40NjdjMC04LjExNiwxLjIzMS0xMS41LTIuMzk3LTEyLjM3NmMtMS4yMDQtMC4yOTEtMi4wOS0wLjQ4My01LjE2OS0wLjUxNCAgIGMtMy45NTItMC4wNDEtNy4yOTcsMC4wMTItOS4xOTEsMC45NGMtMS4yNiwwLjYxNy0yLjIzMiwxLjk5Mi0xLjY0LDIuMDcxYzAuNzMyLDAuMDk4LDIuMzksMC40NDcsMy4yNjksMS42NDQgICBjMS4xMzUsMS41NDQsMS4wOTUsNS4wMTIsMS4wOTUsNS4wMTJzMC42NTIsOS41NTQtMS41MjMsMTAuNzQxYy0xLjQ5MywwLjgxNC0zLjU0MS0wLjg0OC03LjkzOC04LjQ0NiAgIGMtMi4yNTMtMy44OTItMy45NTQtOC4xOTQtMy45NTQtOC4xOTRzLTAuMzI4LTAuODA0LTAuOTEzLTEuMjM0Yy0wLjcxLTAuNTIxLTEuNzAyLTAuNjg3LTEuNzAyLTAuNjg3bC0xMC41MjUsMC4wNjkgICBjMCwwLTEuNTgsMC4wNDQtMi4xNiwwLjczMWMtMC41MTYsMC42MTEtMC4wNDEsMS44NzUtMC4wNDEsMS44NzVzOC4yNCwxOS4yNzgsMTcuNTcsMjguOTkzICAgQzQ0LjI2NCw4MS4yODcsNTMuOTc5LDgwLjcwMiw1My45NzksODAuNzAyTDUzLjk3OSw4MC43MDJ6IiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7ZmlsbDojRkZGRkZGOyIvPjwvZz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48L3N2Zz4=';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function buildLink(){
        global $app;

        $code_verifier = bin2hex(random_bytes(32));
        $code_challenge = hash('sha256', $code_verifier, true);
        $code_challenge = rtrim(strtr(base64_encode($code_challenge), '+/', '-_'), '=');

        $params = array(
          'client_id'     => $this->data->params->id,
          'redirect_uri'  => getHost(true) . "/oauth/vkontakte",
          'scope'         => 'email phone',
          'response_type' => 'code',
          'state'         => $code_verifier,
          'code_verifier' => $code_verifier,
          'code_challenge'=> $code_challenge,
          'code_challenge_method'=>'S256',
        );
         
        return 'https://id.vk.com/authorize?' . urldecode(http_build_query($params));

    }

    public function callback($params=[]){
        global $app;

        $result = [];

        if($params['code'] && $params['device_id']){

            $params = array(
                'code_verifier' => $params['state'],
                'client_id'     => $this->data->params->id,
                'device_id'     => $params['device_id'],
                'redirect_uri'  => getHost() . "/oauth/vkontakte",
                'code'          => $params['code'],
                'grant_type'    => "authorization_code",
                'state'         => $params['state'],
            );

            $data = _json_decode(curl("post", "https://id.vk.com/oauth2/auth", $params));

            if($data['access_token']){

                $params = array(
                    'client_id' => $this->data->params->id,
                    'access_token' => $data['access_token'],
                );

                $get_user_info = _json_decode(curl('post','https://id.vk.com/oauth2/user_info',$params));  
                
                if($get_user_info){
                    $result["email"] = $get_user_info['user']['email'];
                    $result["phone"] = $get_user_info['user']['phone'];
                    $result["name"] = $get_user_info["user"]['first_name'];
                    $result["surname"] = $get_user_info["user"]['last_name'];
                    $result["photo"] = $get_user_info["user"]['avatar'];
                }

            }

        }

        return $result;

    }

    public function fieldsForm($params=[]){
        global $app;

        return '
        <form class="integrationOAuthForm" >

            <h3>'.$this->data->name.'</h3>

            <div class="row">

                <div class="col-12 mb-3">

                  <label class="form-label mb-2" >'.translate("tr_55c9488fbbf51f974a38acd8ccb87ee1").'</label>

                  '.$app->ui->managerFiles(["filename"=>$this->data->image, "type"=>"images", "path"=>"images"]).'

                </div>

                <div class="col-12 mb-3">

                  <label class="form-label mb-2" >'.translate("tr_602680ed8916dcc039882172ef089256").'</label>

                  <input type="text" name="name" class="form-control" value="'.$this->data->name.'" />

                </div>

                <div class="col-12 mb-3">

                  <label class="form-label mb-2" >'.translate("tr_2f269fcea16e6c2d9fe0fe7bf4a662fc").'</label>

                  <input type="text" name="params[id]" class="form-control" value="'.$this->data->params->id.'" />

                </div>

                <div class="col-12 mb-3">

                  <label class="form-label mb-2" >'.translate("tr_a09a7a6e949aab436f7b4bcd16ea8379").'</label>

                  <input type="text" name="params[key]" class="form-control" value="'.$this->data->params->key.'" /> 

                </div>

                <div class="col-12">

                  <label class="form-label mb-2" >'.translate("tr_dc99e9dfc9091711e218c48d6d13ffd9").'</label>

                  <div>'.getHost(true).'/oauth/'.$this->data->alias.'</div>

                </div>

                <input type="hidden" name="id" value="'.$this->data->id.'" />

                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationOAuthSave">'.translate("tr_74ea58b6a801f0dce4e5d34dbca034dc").'</button>
                </div>

            </div>

        </from>
        ';

    }


}