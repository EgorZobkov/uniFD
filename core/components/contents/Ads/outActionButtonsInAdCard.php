public function outActionButtonsInAdCard($data=[]){
    global $app;

    if($data->owner){

        if($data->status == 0){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 1){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme2 width100 actionOpenStaticModal" data-modal-target="adRemovePublication" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><?php echo translate("tr_af1939bb99d547ff54c8623ba556ab5a"); ?></button>
            <?php
        }elseif($data->status == 2){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme1 width100 actionExtendAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_18284259d971525f8d0bf9ae23871fcd"); ?></button>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 3){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 4){
            if(!$data->block_forever_status){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <?php } ?>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 5){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 7){
            ?>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }elseif($data->status == 8){
            ?>
            <a class="btn-custom button-color-scheme1 width100" href="<?php echo outRoute("ad-edit", [$data->id]); ?>" ><?php echo translate("tr_1706282c5244c8e988f76c5eb939b754"); ?></a>
            <button class="btn-custom button-color-scheme6 width100 actionDeleteAdCard" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></button>
            <?php
        }

    }else{

        if($data->status == 1){

            if($data->contact_method == "all"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <button class="btn-custom button-color-scheme2 width100 actionAdShowContacts" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_a3fe3a50afc89c343898bd962c49b514"); ?></button>
                <?php
            }elseif($data->contact_method == "call"){
                ?>
                <button class="btn-custom button-color-scheme2 width100 actionAdShowContacts" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_a3fe3a50afc89c343898bd962c49b514"); ?></button>
                <?php
            }elseif($data->contact_method == "message"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <?php
            }

        }elseif($data->status == 2){

            if($data->contact_method == "all"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <?php
            }elseif($data->contact_method == "message"){
                ?>
                <button class="btn-custom button-color-scheme1 width100 actionOpenDialogueSendMessage" data-params="<?php echo $app->component->chat->buildParams(['ad_id'=>$data->id, 'whom_user_id'=>$data->user_id]); ?>" ><?php echo translate("tr_014478b5b412ab74b6a95f968d4e413d"); ?></button>
                <?php
            }

        }

    }
  
}