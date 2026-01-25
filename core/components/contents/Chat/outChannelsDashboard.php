public function outChannelsDashboard($id=0){
     global $app;

     $channels = $app->model->chat_channels->getAll();

     if($channels){
        foreach ($channels as $value) {

            if(compareValues($id, $value["id"])){
                ?>
                  <a class="chat-sidebar-list-item active" href="<?php echo $app->router->getRoute("dashboard-chat-channel", [$value["id"]]); ?>" >
                    <div class="chat-sidebar-list-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" class="image-autofocus" > </div>
                    <div class="chat-sidebar-list-item-name" ><?php echo translateFieldReplace($value, "name"); ?></div>
                  </a>
                <?php
            }else{
                ?>
                  <a class="chat-sidebar-list-item" href="<?php echo $app->router->getRoute("dashboard-chat-channel", [$value["id"]]); ?>" >
                    <div class="chat-sidebar-list-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" class="image-autofocus" > </div>
                    <div class="chat-sidebar-list-item-name" ><?php echo translateFieldReplace($value, "name"); ?></div>
                  </a>
                <?php
            }

        }
     }

}