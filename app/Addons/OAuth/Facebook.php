<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\OAuth;

class FaceBook{

    public $alias = "facebook";
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
            return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDU1MCA1NTAiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1NTAgNTUwIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48Zz48Zz48Y2lyY2xlIGN4PSIyNzUiIGN5PSIyNzUiIGZpbGw9IiMzRjY1QTYiIHI9IjI1NiIvPjxwYXRoIGQ9Ik0yMzYuMSwxOTAuOGMwLDcuNCwwLDQwLjQsMCw0MC40aC0yOS42djQ5LjRoMjkuNlY0MTZoNjAuOFYyODAuNWg0MC44ICAgICBjMCwwLDMuOC0yMy43LDUuNy00OS42Yy01LjMsMC00Ni4yLDAtNDYuMiwwczAtMjguNywwLTMzLjhjMC01LDYuNi0xMS44LDEzLjItMTEuOGM2LjUsMCwyMC4zLDAsMzMuMSwwYzAtNi43LDAtMzAsMC01MS40ICAgICBjLTE3LjEsMC0zNi41LDAtNDUsMEMyMzQuNiwxMzQsMjM2LjEsMTgzLjQsMjM2LjEsMTkwLjh6IiBmaWxsPSIjRkZGRkZGIiBpZD0iRmFjZWJvb2tfNF8iLz48L2c+PC9nPjwvc3ZnPg==';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function buildLink(){
        global $app;

        $params = array(
          'client_id'     => $this->data->params->id,
          'scope'         => 'email',
          'redirect_uri'  => getHost(true) . "/oauth/facebook",
          'response_type' => 'code',
        );
         
        return 'https://www.facebook.com/dialog/oauth?' . urldecode(http_build_query($params));

    }

    public function callback($params=[]){
        global $app;

        $result = [];

        if($params['code']){

            $params = array(
                'client_id'     => $this->data->params->id,
                'client_secret' => $this->data->params->key,
                'redirect_uri'  => getHost() . "/oauth/facebook",
                'code'          => $params['code']
            );
            
            $data = _json_decode(_file_get_contents('https://graph.facebook.com/oauth/access_token?' . urldecode(http_build_query($params))));
         
            if ($data['access_token']){

                $params = array(
                    'access_token' => $data['access_token'],
                    'fields'       => 'id,email,first_name,last_name,picture,link'
                );
         
                $get_user_info = _json_decode(_file_get_contents('https://graph.facebook.com/me?' . urldecode(http_build_query($params))));

                $result["email"] = $get_user_info['email'];
                $result["name"] = $get_user_info['first_name'];
                $result["surname"] = $get_user_info['last_name'];
                $result["photo"] = $get_user_info['picture']['data']['url'];

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