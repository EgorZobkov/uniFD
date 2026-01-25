public function outStatusInCardShop($data=[]){
    global $app;

    if($data->owner){

        if($data->shop->status == "awaiting_verification"){
        ?>

        <div class="card-status-info card-status-info-bg-moderation" >
          <strong><?php echo translate("tr_a22a6ac5e3bb9c824b6b0defef2b71a8"); ?></strong>
          <p><?php echo translate("tr_d992e9794e23f088bf7e891773f29669"); ?></p>
        </div>

        <?php }elseif($data->shop->status == "blocked"){ ?>

        <div class="card-status-info card-status-info-bg-error" >
          <strong><?php echo translate("tr_72492cec85a3f7ca9b61a7a32949f5aa"); ?></strong>
        </div>

        <?php }elseif($data->shop->status == "rejected"){ ?>

        <div class="card-status-info card-status-info-bg-error"  >
          <strong><?php echo translate("tr_2943837ba61e63136527be245b0cbd2f"); ?></strong>
          <p><?php echo $data->shop->comment; ?></p>
        </div>

        <?php
        }

        
    }

}