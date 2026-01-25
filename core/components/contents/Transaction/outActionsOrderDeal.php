public function outActionsOrderDeal($data=[]){
    global $app;

      if($data->from_user_id == $app->user->data->id){

        if($data->status_processing == "awaiting_confirmation"){

            if(!$data->item->booking_status){
                echo translate("tr_adedfabc674e7efd3d316f4111b58a7b");
                ?>

                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                </div>

                <?php
            }else{
                echo translate("tr_140ab83e84e71d7d537f3f334d67bc25");
                ?>

                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                </div>

                <?php
            }

        }elseif($data->status_processing == "confirmed_order"){

            if(!$data->item->booking_status){

                if($data->item->category->type_goods == "physical_goods"){
                    if($data->delivery_service_id){
                        echo translate("tr_49719417c532c5cb93fb1bcfb64a4ccd");
                    }else{
                        echo translate("tr_b5a0e321d5daa89eecb9e461cfd53cc5");                        
                    }
                }elseif($data->item->category->type_goods == "services"){
                    echo translate("tr_abe06f92ce38481cf4e0a13203d2b053");
                }

            }else{

                echo translate("tr_c5cb17572975ff74c1988fb85bd1df0a");

                ?>
                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme1 initPaymentOrderSecureDeal" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e1f7d614ec62e7651cd1c77c6f3a8afb"); ?></button> 
                   <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                  
                </div> 
                <?php                    

            }

        }elseif($data->status_processing == "access_open"){

            echo translate("tr_409c4a591bae436a2f1f192dc3177d4a")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));

            ?>
            <div class="order-card-section-action-info" >
                <?php echo outTextWithLinks(decrypt($data->item->external_content)); ?>
            </div>                    

            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_49eb66b6229f98e4afbe115b412844fe"); ?></button>    
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>               
            </div>                    
            <?php

        }elseif($data->status_processing == "confirmed_send_shipment"){

            ?>

            <div><?php echo translate("tr_3f23e7324e00c06595d0fecb5838fdbd"); ?></div>

            <div class="mt10" ><?php echo translate("tr_bc95f0b22f1d9f54fe526bf39c1b97cc"); ?> <strong><?php echo $data->delivery_service->name; ?></strong> </div>

            <?php if($data->delivery_answer_data["comment_to_recipient"]){ ?>
            <div class="mt10" ><?php echo $data->delivery_answer_data["comment_to_recipient"]; ?></div>
            <?php } ?>

            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1 actionOpenStaticModal" data-modal-target="deliveryHistory" data-modal-params="<?php echo buildAttributeParams(["order_id"=>$data->order_id]); ?>" ><?php echo translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"); ?></button>
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_88c22e531b9c4cf920aead3329f5bfa6"); ?></button>    
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>               
            </div>

            <?php

        }elseif($data->status_processing == "confirmed_transfer"){

            echo translate("tr_8518db38f8e990fa9ba83bcc1539d00e")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));
            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_88c22e531b9c4cf920aead3329f5bfa6"); ?></button>      
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>              
            </div>

            <?php

        }elseif($data->status_processing == "confirmed_completion_service"){

            echo translate("tr_afdfc6e0b45a15e90b586efd5b2adb5b")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));
            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1" data-bs-target="#completedModal" data-bs-toggle="modal" ><?php echo translate("tr_038001628d0014bc8718b42d1405ea18"); ?></button>     
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>              
            </div>

            <?php

        }elseif($data->status_processing == "completed_order"){

            $infoPayment = $this->outInfoPaymentsOrderDeal($data->order_id, $app->user->data->id);

            if($infoPayment){
            ?>
                <div class="order-card-section-action-info" >
                    <?php
                        echo $infoPayment;
                    ?>
                </div>
            <?php
            }

            if($data->item->external_content){
                ?>

                <div class="order-card-section-action-info" >
                    <?php echo outTextWithLinks(decrypt($data->item->external_content)); ?>
                </div> 

                <?php
            }

        }elseif($data->status_processing == "open_dispute"){

            echo translate("tr_572361ee356ac71a2d8b92b04ebcc5e2");
            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1 actionCloseDisputeOrderDeal" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_cbcae031aaf24f2be3b3cd22d4d0fb9b"); ?></button>                   
            </div>

            <?php

        }elseif($data->status_processing == "booked"){

            ?>
            
            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button> 
               <button class="btn-custom-mini button-color-scheme2" data-bs-target="#disputeModal" data-bs-toggle="modal" ><?php echo translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"); ?></button>                  
            </div>

            <?php

        }

      }

      if($data->whom_user_id == $app->user->data->id){

        if($data->status_processing == "awaiting_confirmation"){

            echo translate("tr_33f03b454585b2ff07d9403c30bb434c");

            if($data->delivery_service_id){

                if($data->user_shipping){

                    ?>
                      <div class="order-card-section-action-buttons" >
                         <button class="btn-custom-mini button-color-scheme1 actionChangeStatusOrderDeal" data-status="confirmed_order" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
                         <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                      </div>
                    <?php

                }else{

                    ?>
                      <div class="order-card-section-action-buttons" >
                         <a class="btn-custom-mini button-color-scheme3" href="<?php echo $app->router->getRoute("profile-settings"); ?>?tab=delivery" target="_blank" ><?php echo translate("tr_8947979f1038a8bf293854cec9e73b6a"); ?></a>
                         <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
                      </div>
                    <?php

                }

            }else{
            ?>
              <div class="order-card-section-action-buttons" >
                 <button class="btn-custom-mini button-color-scheme1 actionChangeStatusOrderDeal" data-status="confirmed_order" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></button>
                 <button class="btn-custom-mini button-color-scheme2" data-bs-target="#cancelOrderModal" data-bs-toggle="modal" ><?php echo translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"); ?></button>                    
              </div>
            <?php
            }

        }elseif($data->status_processing == "confirmed_order"){

            if($data->item->category->type_goods == "physical_goods"){

                if(!$data->item->booking_status){
                    if($data->delivery_service_id){
                        ?>

                        <div><?php echo translate("tr_6b39bdae95e723918fb0337826bdcd90"); ?><strong><?php echo $data->user_shipping_point->address; ?>, <?php echo $data->delivery_service->name; ?></strong></div>

                        <?php if($data->delivery_answer_data["comment_to_sender"]){ ?>
                        <div class="mt10" ><?php echo $data->delivery_answer_data["comment_to_sender"]; ?></div>
                        <?php } ?>

                        <div class="order-card-section-action-buttons" >
                           <button class="btn-custom-mini button-color-scheme1 actionOpenStaticModal" data-modal-target="deliveryHistory" data-modal-params="<?php echo buildAttributeParams(["order_id"=>$data->order_id]); ?>" ><?php echo translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"); ?></button>
                           <button class="btn-custom-mini button-color-scheme5 actionChangeStatusOrderDeal" data-status="confirmed_send_shipment" data-id="<?php echo $data->order_id; ?>" ><?php echo translate("tr_d458374e3228a9c45017b98ff1241e86"); ?></button>                   
                        </div>
                        <?php
                    }else{
                        echo translate("tr_25ff13482d796c27b197ad05d7ed522a");
                        ?>
                        <div class="order-card-section-action-buttons" >
                           <button class="btn-custom-mini button-color-scheme5" data-bs-target="#executionModal" data-bs-toggle="modal" ><?php echo translate("tr_eaec2623204b61af4ee3d78d01dae0ce"); ?></button>                   
                        </div>
                        <?php                        
                    }
                }

            }elseif($data->item->category->type_goods == "services"){
                ?>
                <div class="order-card-section-action-buttons" >
                   <button class="btn-custom-mini button-color-scheme1" data-bs-target="#executionModal" data-bs-toggle="modal" ><?php echo translate("tr_038001628d0014bc8718b42d1405ea18"); ?></button>                   
                </div>
                <?php
            }

        }elseif($data->status_processing == "access_open"){

            echo translate("tr_90a74c8fc8c8add56d9524f76cce9fd7")." ".$app->settings->secure_deal_auto_closing_time." ".endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));

        }elseif($data->status_processing == "confirmed_send_shipment"){

            ?>
            <div class="order-card-section-action-info" ><?php echo $app->system->amount($this->calculationDealProfitUserPayments($data->amount, $data->delivery_amount)); ?> <?php echo translate("tr_6f07e1f8fa38e0b51401b846f6d3866c"); ?></div>

            <div class="order-card-section-action-buttons" >
               <button class="btn-custom-mini button-color-scheme1 actionOpenStaticModal" data-modal-target="deliveryHistory" data-modal-params="<?php echo buildAttributeParams(["order_id"=>$data->order_id]); ?>" ><?php echo translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"); ?></button>      
            </div>
            <?php 

        }elseif($data->status_processing == "confirmed_transfer" || $data->status_processing == "confirmed_completion_service"){

            ?>
            <div class="order-card-section-action-info" ><?php echo $app->system->amount($this->calculationDealProfitUserPayments($data->amount, $data->delivery_amount)); ?> <?php echo translate("tr_1eb131f3df87d0b96aa2670c059c1bd7") . ' ' . $app->settings->secure_deal_auto_closing_time . ' ' . endingWord($app->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340")); ?></div>
            <?php 

        }elseif($data->status_processing == "completed_order"){

            $infoPayment = $this->outInfoPaymentsOrderDeal($data->order_id, $app->user->data->id);

            if($infoPayment){
            ?>
            <div class="order-card-section-action-info" >
                <?php
                    echo $infoPayment;
                ?>
            </div>
            <?php
            }

        }elseif($data->status_processing == "open_dispute"){

            echo translate("tr_572361ee356ac71a2d8b92b04ebcc5e2");

        }

      }

}