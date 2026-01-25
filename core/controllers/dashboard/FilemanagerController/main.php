public function main(){   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/filemanager.js\" type=\"module\" ></script>"]);

}