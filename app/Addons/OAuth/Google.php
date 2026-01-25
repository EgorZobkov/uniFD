<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\OAuth;

class Google{

    public $alias = "google";
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
            return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDUxMiA1MTIiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48Zz48cGF0aCBkPSJNNDIuNCwxNDUuOWMxNS41LTMyLjMsMzcuNC01OS42LDY1LTgyLjNjMzcuNC0zMC45LDgwLjMtNDkuNSwxMjguNC01NS4yYzU2LjUtNi43LDEwOS42LDQsMTU4LjcsMzMuNCAgIGMxMi4yLDcuMywyMy42LDE1LjYsMzQuNSwyNC42YzIuNywyLjIsMi40LDMuNSwwLjEsNS43Yy0yMi4zLDIyLjItNDQuNiw0NC40LTY2LjcsNjYuOGMtMi42LDIuNi00LDIuNC02LjgsMC4zICAgYy02NC44LTQ5LjktMTU5LjMtMzYuNC0yMDcuNiwyOS42Yy04LjUsMTEuNi0xNS40LDI0LjEtMjAuMiwzNy43Yy0wLjQsMS4yLTEuMiwyLjMtMS44LDMuNWMtMTIuOS05LjgtMjUuOS0xOS42LTM4LjctMjkuNSAgIEM3Mi4zLDE2OSw1Ny4zLDE1Ny41LDQyLjQsMTQ1Ljl6IiBmaWxsPSIjRTk0MzM1Ii8+PHBhdGggZD0iTTEyNiwzMDMuOGM0LjMsOS41LDcuOSwxOS40LDEzLjMsMjguM2MyMi43LDM3LjIsNTUuMSw2MS4xLDk3LjgsNjkuNmMzOC41LDcuNyw3NS41LDIuNSwxMTAtMTYuOCAgIGMxLjItMC42LDIuNC0xLjIsMy41LTEuOGMwLjYsMC42LDEuMSwxLjMsMS43LDEuOGMyNS44LDIwLDUxLjcsNDAsNzcuNSw2MGMtMTIuNCwxMi4zLTI2LjUsMjIuMi00MS41LDMwLjggICBjLTQzLjUsMjQuOC05MC42LDM0LjgtMTQwLjIsMzFDMTg2LjMsNTAxLjksMTMzLDQ3Ny41LDg5LDQzMy41Yy0xOS4zLTE5LjMtMzUuMi00MS4xLTQ2LjctNjZjMTAuNy04LjIsMjEuNC0xNi4zLDMyLjEtMjQuNSAgIEM5MS42LDMyOS45LDEwOC44LDMxNi45LDEyNiwzMDMuOHoiIGZpbGw9IiMzNEE4NTMiLz48cGF0aCBkPSJNNDI5LjksNDQ0LjljLTI1LjgtMjAtNTEuNy00MC03Ny41LTYwYy0wLjYtMC41LTEuMi0xLjItMS43LTEuOGM4LjktNi45LDE4LTEzLjYsMjUuMy0yMi40ICAgYzEyLjItMTQuNiwyMC4zLTMxLjEsMjQuNS00OS42YzAuNS0yLjMsMC4xLTMuMS0yLjItM2MtMS4yLDAuMS0yLjMsMC0zLjUsMGMtNDAuOCwwLTgxLjctMC4xLTEyMi41LDAuMWMtNC41LDAtNS41LTEuMi01LjQtNS41ICAgYzAuMi0yOSwwLjItNTgsMC04N2MwLTMuNywxLTQuNyw0LjctNC43Yzc0LjgsMC4xLDE0OS42LDAuMSwyMjQuNSwwYzMuMiwwLDQuNSwwLjgsNS4zLDQuMmM2LjEsMjcuNSw1LjcsNTUuMSwyLDgyLjkgICBjLTMsMjIuMi04LjQsNDMuNy0xNi43LDY0LjVjLTEyLjMsMzAuNy0zMC40LDU3LjUtNTQuMiw4MC41QzQzMS42LDQ0My44LDQzMC43LDQ0NC4zLDQyOS45LDQ0NC45eiIgZmlsbD0iIzQyODVGMyIvPjxwYXRoIGQ9Ik0xMjYsMzAzLjhjLTE3LjIsMTMuMS0zNC40LDI2LjEtNTEuNiwzOS4yYy0xMC43LDguMS0yMS40LDE2LjMtMzIuMSwyNC41QzM0LDM1Mi4xLDI4LjYsMzM1LjgsMjQuMiwzMTkgICBjLTguNC0zMi41LTkuNy02NS41LTUuMS05OC42YzMuNi0yNiwxMS4xLTUxLDIzLjItNzQuNGMxNSwxMS41LDI5LjksMjMuMSw0NC45LDM0LjZjMTIuOSw5LjksMjUuOCwxOS43LDM4LjcsMjkuNSAgIGMtMi4yLDEwLjctNS4zLDIxLjItNi4zLDMyLjJjLTEuOCwyMCwwLjEsMzkuNSw1LjgsNTguN0MxMjUuOCwzMDEuOCwxMjUuOSwzMDIuOCwxMjYsMzAzLjh6IiBmaWxsPSIjRkFCQjA2Ii8+PC9nPjwvc3ZnPg==';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function buildLink(){
        global $app;

        $params = array(
            'client_id'     => $this->data->params->id,
            'redirect_uri'  => getHost(true) . "/oauth/google",
            'response_type' => 'code',
            'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'state'         => '123'
        );
         
        return 'https://accounts.google.com/o/oauth2/auth?' . urldecode(http_build_query($params));

    }

    public function callback($params=[]){
        global $app;

        $result = [];

        if($params['code']) {

            $params = array(
                'client_id'     => $this->data->params->id,
                'client_secret' => $this->data->params->key,
                'redirect_uri'  => getHost() . "/oauth/google",
                'grant_type'    => 'authorization_code',
                'code'          => $params['code'],
            );  
                    
            $ch = curl_init('https://accounts.google.com/o/oauth2/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);

            $data = _json_decode(curl_exec($ch));
            curl_close($ch);    
         
            if($data['access_token']){

                $params = array(
                    'access_token' => $data['access_token'],
                    'id_token'     => $data['id_token'],
                    'token_type'   => 'Bearer',
                    'expires_in'   => 3599
                );
         
                $get_user_info = _json_decode(_file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?' . urldecode(http_build_query($params))));

                $result["email"] = $get_user_info['email'];
                $result["name"] = $get_user_info['given_name'];
                $result["surname"] = $get_user_info['family_name'];
                $result["photo"] = $get_user_info['picture'];

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