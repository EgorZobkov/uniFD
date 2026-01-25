 public function loadDeliveryPointItem()
{   

    ob_start();

    $content = '';
    $params = _json_decode(urldecode($_POST["params"]));

    if(!$_POST['id']){
        return json_answer(["content"=>""]);
    }

    $data = $this->model->delivery_points->find("id=?", [$_POST['id']]);

    if($data){

        $delivery = $this->model->system_delivery_services->find("id=?", [$data->delivery_id]);

        if(!$params['send']){
            $calculationData = $this->component->delivery->calculationData($data->id, $params['item_id'], $this->user->data->id);
        }

        ?>
        <div class="btn-custom-mini button-color-scheme2 actionCloseSidebarMapDelivery" ><?php echo translate("tr_dd9463bd5d0c650b468fc5d6cfa1073c"); ?></div>
        <div class="mt20">
          <img src="<?php echo $this->addons->delivery($delivery->alias)->logo(); ?>" height="30" style="margin-right: 5px;" >
          <?php echo $delivery->name; ?>
        </div>
        <div class="mt10" >
            <h5><?php echo $data->address; ?></h5>

            <?php if($calculationData["status"] == true){ ?>
            <p class="font-bold" ><?php echo translate("tr_b973ee86903271172c9b4f5529bc19bb"); ?> <?php echo $calculationData["amount"]; ?>, <?php echo $calculationData["days"]; ?></p>
            <?php } ?>

            <p><?php echo $data->workshedule; ?></p>
            <p><?php echo $data->text; ?></p>

            <?php

            if(!$params['send']){

                if($delivery->required_price_order){
                    if($calculationData["status"] == true){
                        ?>
                        <div class="btn-custom-mini button-color-scheme3 actionChangePointMapDelivery" data-point="<?php echo $delivery->name; ?>, <?php echo $data->address; ?>" data-delivery-amount="<?php echo $calculationData["amount_formatted"]; ?>" data-delivery-days="<?php echo $calculationData["days"]; ?>" data-id="<?php echo $data->id; ?>" data-point-code="<?php echo $data->code; ?>" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
                        <?php
                    }else{
                        ?>
                        <div class="mt10 font-bold" ><?php echo translate("tr_7c8a6b672aec9e67d4591cc551a3beab"); ?></div>
                        <?php                    
                    }
                }else{
                    ?>
                    <div class="btn-custom-mini button-color-scheme3 actionChangePointMapDelivery" data-point="<?php echo $delivery->name; ?>, <?php echo $data->address; ?>" data-id="<?php echo $data->id; ?>" data-point-code="<?php echo $data->code; ?>" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
                    <?php
                }

            }else{

                ?>
                <div class="btn-custom-mini button-color-scheme3 actionChangePointMapDelivery" data-point="<?php echo $delivery->name; ?>, <?php echo $data->address; ?>" data-id="<?php echo $data->id; ?>" data-point-code="<?php echo $data->code; ?>" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
                <?php

            }

            ?>

        </div>
        <?php

    }

    $content = ob_get_contents();
    ob_end_clean();

    return json_answer(["content"=>$content]);

}