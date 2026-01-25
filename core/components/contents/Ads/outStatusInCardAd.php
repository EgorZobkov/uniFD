public function outStatusInCardAd($data){
    global $app;

    if($data->owner){

        if($data->status == 0){
        ?>

        <div class="card-status-info card-status-info-bg-moderation" >
          <strong><?php echo translate("tr_779b189b218a6dd96008e19f7fd22883"); ?></strong>
          <p><?php echo translate("tr_6f1d4db88ab60d7914ea35150d27bcc2"); ?></p>
        </div>

        <?php }elseif($data->status == 2){ ?>

        <div class="card-status-info card-status-info-bg-gray" >
          <strong><?php echo translate("tr_f279ae952a1d2ef597edd30b9a4044e8"); ?></strong>
          <p><?php echo translate("tr_b6266c285d96b8a5397cb7dcd09230c2"); ?></p>
        </div>

        <?php }elseif($data->status == 3){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_320386a36d375bcf1b05f292e4463e4b"); ?></strong>
          <p><?php echo translate("tr_b6266c285d96b8a5397cb7dcd09230c2"); ?></p>
        </div>

        <?php
        }elseif($data->status == 4){ ?>

        <div class="card-status-info card-status-info-bg-error" >
          <strong><?php echo translate("tr_5f9e133baa87da7c530ce299740bbec9"); ?></strong>
          <p><?php echo translate("tr_ce28b881ebd7df5f6f26f319aeb91a30"); ?> <?php echo $data->reason->text; ?></p>
          <?php if(!$data->block_forever_status){ ?>
          <p><?php echo translate("tr_2cbcf582e3ff7a6efbbbbcfd1a4888a7"); ?></p>
          <?php } ?>
        </div>

        <?php }elseif($data->status == 5){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_f0c85f1f5bb88b14ca1c6974cc805977"); ?></strong>
          <p><?php echo translate("tr_dce9f41b065a92f2631bbbb180aa5eba"); ?></p>
          <?php echo $app->component->transaction->buildPaymentButton(["target"=>"paid_category", "id"=>$data->id, "class"=>"btn-custom button-color-scheme1 mt15"]); ?>
        </div>

        <?php
        }elseif($data->status == 6){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_204430ebf3bce6664d8e03e9fd1581ce"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 7){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_5890c2583af9a6b327d4d51f828678e7"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 8){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_601f38d372da3494796935405b52a3b3"); ?></strong>
          <p><?php echo translate("tr_32d52a75101c6cd92535651104533bd0"); ?></p>
        </div>

        <?php
        }

    }else{

        if($data->status == 0){
        ?>

        <div class="card-status-info card-status-info-bg-moderation" >
          <strong><?php echo translate("tr_779b189b218a6dd96008e19f7fd22883"); ?></strong>
        </div>

        <?php }elseif($data->status == 2){ ?>

        <div class="card-status-info card-status-info-bg-gray" >
          <strong><?php echo translate("tr_f279ae952a1d2ef597edd30b9a4044e8"); ?></strong>
        </div>

        <?php }elseif($data->status == 3){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_320386a36d375bcf1b05f292e4463e4b"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 4){ ?>

        <div class="card-status-info card-status-info-bg-error" >
          <strong><?php echo translate("tr_5f9e133baa87da7c530ce299740bbec9"); ?></strong>
        </div>

        <?php }elseif($data->status == 5){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_47f1f18a961cd149db1dc53ba4b31b37"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 6){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_204430ebf3bce6664d8e03e9fd1581ce"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 7){ ?>

        <div class="card-status-info card-status-info-bg-success"  >
          <strong><?php echo translate("tr_5890c2583af9a6b327d4d51f828678e7"); ?></strong>
        </div>

        <?php
        }elseif($data->status == 7){ ?>

        <div class="card-status-info card-status-info-bg-gray"  >
          <strong><?php echo translate("tr_601f38d372da3494796935405b52a3b3"); ?></strong>
        </div>

        <?php
        }

    }

}