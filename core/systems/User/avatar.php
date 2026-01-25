public function avatar($data=[]){
    global $app;

    ?>
    <img class="image-autofocus" src="<?php echo $app->storage->name($data->avatar)->get(); ?>">
    <?php

}