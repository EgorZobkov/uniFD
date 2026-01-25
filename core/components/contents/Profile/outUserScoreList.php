public function outUserScoreList($user_id=0){
    global $app;
    $payments = $app->model->users_payment_data->getAll("user_id=?", [$user_id]);
    if($payments){
        foreach ($payments as $key => $value) {
            $value["score"] = decrypt($value["score"]);
            ?>
              <div class="credit-card selectable">
                  <span class="actionAddDefaultPaymentScore" data-id="<?php echo $value["id"]; ?>" > <?php if($value["default_status"]){ ?> <i class="ti ti-target active-yellow"></i> <?php }else{ ?> <i class="ti ti-target"></i> <?php } ?></span>
                  <span class="actionDeletePaymentScore" data-id="<?php echo $value["id"]; ?>" ><i class="ti ti-trash"></i></span>
                  <div class="credit-card-last4">
                      <?php echo substr($value["score"], strlen($value["score"])-4, strlen($value["score"])); ?>
                  </div>
              </div>
            <?php
        }
    }
}