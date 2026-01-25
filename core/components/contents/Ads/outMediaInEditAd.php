public function outMediaInEditAd($data=[]){
    global $app;

    if($data->media->images->all){

      foreach ($data->media->inline as $key => $value) {

            if($value->name){

                $name = getInfoFile($value->name)->filename;

                if($value->type == "image"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $value->link; ?>" >
                      <input type="hidden" name="media[][image]" value="<?php echo $name; ?>" >
                    </div>
                    <?php
                }elseif($value->type == "video"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $value->preview; ?>" >
                      <input type="hidden" name="media[][video]" value="<?php echo $name; ?>" >
                    </div>
                    <?php
                }

            }else{

                if($value->type == "image"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $value->link; ?>" >
                      <input type="hidden" name="media[][image]" value="<?php echo $value->link; ?>" >
                    </div>
                    <?php
                }elseif($value->type == "video"){
                    ?>
                    <div class="unidropzone-item" >
                      <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                      <img class="image-autofocus" src="<?php echo $app->storage->noImage(); ?>" >
                      <input type="hidden" name="media[][video]" value="<?php echo $value->link; ?>" >
                    </div>
                    <?php
                }                

            }

      }

    }

}