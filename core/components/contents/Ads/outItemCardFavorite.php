public function outItemCardFavorite($data=[], $user_id=0){
    global $app;

    if($data->user_id != $user_id){
    ?>

      <div class="container-item-favorite actionManageFavorite" data-id="<?php echo $data->id; ?>" >
        <?php if($app->component->profile->inFavorite($data->id, $user_id)){ ?>
            <i class="ti ti-heart-filled"></i>
        <?php }else{ ?>
            <i class="ti ti-heart"></i>
        <?php } ?>
      </div>

    <?php
    }

}