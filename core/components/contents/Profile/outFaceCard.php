public function outFaceCard($data=[]){
    global $app;

    $user = $app->model->users->cacheKey(["id"=>$data->user->id])->find('id=?', [$data->user->id]);
    
    if($user){
        return '
        <div class="box-user-face-card">
                
            <div class="box-user-face-card-avatar">
              
                <div>
                  <img class="image-autofocus" src="'.$app->storage->name($user->avatar)->get().'">
                </div>

            </div>

            <div class="box-user-face-card-content">

                 '.$app->user->name($user).' '.$this->verificationLabel($user->verification_status).'
                
            </div>

        </div>
        ';
    }

}