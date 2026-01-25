public function outContactSocialLinks(){
    global $app;

    if($app->settings->contact_social_links){
        foreach ($app->settings->contact_social_links as $key => $value) {
            ?>

            <div class="col-12 mb-2 contact-social-link-item">

              <div class="row" >
                <div class="col-12 col-md-3 mb-1" >
                  <input type="text" name="contact_social_links[<?php echo $key; ?>][name]" class="form-control" placeholder="<?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?>" value="<?php echo $value["name"] ?: ""; ?>" /> 
                </div>
                <div class="col-12 col-md-4 mb-1" >
                  <input type="text" name="contact_social_links[<?php echo $key; ?>][link]" class="form-control" placeholder="<?php echo translate("tr_9797b9494600869ec6a941dae3f2a198"); ?>" value="<?php echo $value["link"] ?: ""; ?>" /> 
                </div>
                <div class="col-12 col-md-4 mb-1" >
                  <input type="text" name="contact_social_links[<?php echo $key; ?>][image]" class="form-control" placeholder="<?php echo translate("tr_22ded0df4bf2dbd70dc9699b69ee9cd9"); ?>" value="<?php echo $value["image"] ?: ""; ?>" /> 
                </div>
                <div class="col-12 col-md-1" >
                  <span class="btn btn-icon btn-label-danger waves-effect settingsInformationDeleteSocialLink"><i class="ti ti-trash"></i></span> 
                </div>
              </div>

            </div>

            <?php
        }
    }

}