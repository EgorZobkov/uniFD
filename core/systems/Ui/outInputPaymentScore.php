public function outInputPaymentScore($payment_service=[]){
    global $app;

    if($payment_service->type_score == "score_card"){
        ?>
        <input type="text" name="payment_score" class="form-control" placeholder="<?php echo $payment_service->type_score_name; ?>" >
        <?php
    }elseif($payment_service->type_score == "score_wallet"){
        ?>
        <input type="text" name="payment_score" class="form-control" placeholder="<?php echo $payment_service->type_score_name; ?>" >
        <?php
    }else{
        ?>
        <input type="text" name="payment_score" class="form-control" placeholder="<?php echo $payment_service->type_score_name; ?>" >
        <?php        
    }

}