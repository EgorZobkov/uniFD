<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\OAuth;

class Yandex{

    public $alias = "yandex";
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
            return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHRpdGxlPmZpbGVfdHlwZV95YW5kZXg8L3RpdGxlPjxwYXRoIGQ9Ik0yMS44OCwyaC00Yy00LDAtOC4wNywzLTguMDcsOS42MmE4LjMzLDguMzMsMCwwLDAsNC4xNCw3LjY2TDksMjguMTNBMS4yNSwxLjI1LDAsMCwwLDksMjkuNGExLjIxLDEuMjEsMCwwLDAsMSwuNmgyLjQ5YTEuMjQsMS4yNCwwLDAsMCwxLjItLjc1bDQuNTktOWguMzR2OC42MkExLjE0LDEuMTQsMCwwLDAsMTkuODIsMzBIMjJhMS4xMiwxLjEyLDAsMCwwLDEuMTYtMS4wNlYzLjIyQTEuMTksMS4xOSwwLDAsMCwyMiwyWk0xOC43LDE2LjI4aC0uNTljLTIuMywwLTMuNjYtMS44Ny0zLjY2LTUsMC0zLjksMS43My01LjI5LDMuMzQtNS4yOWguOTRaIiBzdHlsZT0iZmlsbDojZDYxZTNiIi8+PC9zdmc+';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function buildLink(){
        global $app;

        $params = array(
            'client_id'     => $this->data->params->id,
            'redirect_uri'  => getHost(true) . "/oauth/yandex",
            'response_type' => 'code',
            'state'         => '123'
        );
         
        return 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($params));

    }

    public function callback($params=[]){
        global $app;

        $result = [];

        if($params['code']){

            $params = array(
                'grant_type'    => 'authorization_code',
                'code'          => $params['code'],
                'client_id'     => $this->data->params->id,
                'client_secret' => $this->data->params->key,
            );
            
            $ch = curl_init('https://oauth.yandex.ru/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);

            $data = _json_decode(curl_exec($ch));
            curl_close($ch);    
                     
            if ($data['access_token']) {

                $ch = curl_init('https://login.yandex.ru/info');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('format' => 'json')); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $data['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HEADER, false);

                $get_user_info = _json_decode(curl_exec($ch));
                curl_close($ch);
         
                $result["email"] = $get_user_info['default_email'];
                $result["name"] = $get_user_info['first_name'];
                $result["surname"] = $get_user_info['last_name'];
                $result["photo"] =  !$get_user_info['is_avatar_empty'] ? 'https://avatars.yandex.net/get-yapic/'.$get_user_info['default_avatar_id'].'/islands-retina-50' : '';

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