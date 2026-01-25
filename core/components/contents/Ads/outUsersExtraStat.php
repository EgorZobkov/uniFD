public function outUsersExtraStat($ad_id=0, $view=null){
    global $app;

    if($ad_id && $view){

        $ad = $app->model->ads_data->find("id=? and user_id=?", [$ad_id, $app->user->data->id]);

        if($ad){

            if($view == "cart"){

                $data = $app->model->cart->getAll("item_id=?", [$ad_id]);

                if($data){

                    foreach ($data as $key => $value) {
                        $user = $app->model->users->findById($value["user_id"]);
                        ?>
                        <div class="ad-users-info-stat-item" >
                            <div><img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus" ></div>
                            <span><?php echo $app->user->name($user); ?></span>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p><?php echo translate("tr_c2c930fb0cfdeac7cbbf0ed285aa3b38"); ?></p>
                    <?php
                }

            }elseif($view == "favorite"){
                
                $data = $app->model->users_favorites->getAll("ad_id=?", [$ad_id]);

                if($data){

                    foreach ($data as $key => $value) {
                        $user = $app->model->users->findById($value["user_id"]);
                        ?>
                        <div class="ad-users-info-stat-item" >
                            <div><img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus" ></div>
                            <span><?php echo $app->user->name($user); ?></span>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p><?php echo translate("tr_c2c930fb0cfdeac7cbbf0ed285aa3b38"); ?></p>
                    <?php
                }

            }elseif($view == "contacts"){
                
                $data = $app->model->users_actions->getAll("item_id=? and action_code=?", [$ad_id, "view_ad_contacts"]);

                if($data){

                    foreach ($data as $key => $value) {
                        $user = $app->model->users->findById($value["from_user_id"]);
                        ?>
                        <div class="ad-users-info-stat-item" >
                            <div><img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus" ></div>
                            <span><?php echo $app->user->name($user); ?></span>
                        </div>
                        <?php
                    }

                }else{
                    ?>
                    <p><?php echo translate("tr_c2c930fb0cfdeac7cbbf0ed285aa3b38"); ?></p>
                    <?php
                }

            }

        }
    }

}