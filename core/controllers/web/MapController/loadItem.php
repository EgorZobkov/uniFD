public function loadItem()
{   

    ob_start();

    $content = '';

    if(!$_POST['id']){
        return json_answer(["content"=>""]);
    }

    $data = $this->component->ads->getAd($_POST['id']);

    if($data){

        $data->owner = $data->user_id == $this->user->data->id ? true : false;

        $this->session->setNestedSubarray("ad-contact", $data->id, $data->id);

        $data->in_favorites = $this->component->profile->inFavorite($_POST['id'], $this->user->data->id);

        $property = $this->component->ads_filters->outPropertyAd($data->id);
        if($property){
            $data->property = $property;
        }

        if(!$data->owner){
            $this->component->ads->fixView($data->id, $this->user->data->id);
        }

        ?>
        <div class="btn-custom-mini button-color-scheme2 actionMapShowItems" ><?php echo translate("tr_2b0b0225a86bb67048840d3da9b899bc"); ?></div>
        <div class="search-map-sidebar-card-container ad-card-content" >

            <div class="row" >

              <div class="col-md-9" >

                <div class="ad-card-info-line" >
                  <span><?php echo $this->datetime->outLastTime($data->time_create); ?></span>
                </div>

              </div>

              <div class="col-md-3 text-end" >

                <div class="ad-card-menu-line" >

                  <?php if($this->user->isAuth()){ ?>
                  <span class="action-to-favorite actionManageFavorite ad-card-menu-line-item active-scale" data-id="<?php echo $data->id; ?>" > <?php if($data->in_favorites){ ?> <i class="ti ti-heart-filled"></i> <?php }else{ ?> <i class="ti ti-heart"></i> <?php } ?> </span>
                  <span class="ad-card-menu-line-item active-scale actionOpenStaticModal" data-modal-target="adShare" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><i class="ti ti-share-3"></i></span>
                  <span class="ad-card-menu-line-item" > 
                    
                    <div class="uni-dropdown">
                      <span class="uni-dropdown-name"> <i class="ti ti-dots"></i> </span>  
                      <div class="uni-dropdown-content uni-dropdown-content-align-right" >
                       <span class="uni-dropdown-content-item actionOpenStaticModal" data-modal-target="adComplain" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><?php echo translate("tr_a7d9ae0c14b6559b102994d3f798a934"); ?></span>
                      </div>               
                    </div>

                  </span>
                  <?php } ?>

                </div>

              </div>      

            </div>

            <h4 class="mt20 text-break-word" ><a href="<?php echo $this->component->ads->buildAliasesAdCard($data); ?>" target="_blank" ><?php echo $data->title; ?></a></h4>

            <div class="mt20" >
                <?php echo $this->component->ads->outMediaGalleryInCard($data, ["height"=>"150px"]); ?>
            </div>

            <div class="ad-card-prices mt10" >

               <?php echo $this->component->ads->outPrices($data); ?>

               <?php echo $this->component->ads->outPriceDifferentCurrenciesInAdCard($data); ?>

            </div>

            <div class="ad-card-action-buttons mt20" >
               <?php echo $this->component->ads->outActionButtonsInAdCard($data); ?>
            </div>

            <div class="ad-card-content-item mt20" >
              <p class="ad-card-subtitle" ><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></p>

              <p class="text-break-word" ><?php echo outTextWithLinks($data->text); ?></p>
            </div>

            <?php if($data->property){ ?>

            <div class="ad-card-content-item mt20" >
              <p class="ad-card-subtitle" ><?php echo translate("tr_d6f9a39be4b8938d8499ac3b525abea7"); ?></p>

              <div class="ad-card-list-properties">
                <?php echo $data->property; ?>
              </div>

            </div>

            <?php } ?>

        </div>
        <?php

    }

    $content = ob_get_contents();
    ob_end_clean();

    return json_answer(["content"=>$content]);

}