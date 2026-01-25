
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_4494d573fcfd21edaa313456eb3b3cc6"); ?></h2>
</div>

<form class="formAddCategory" >

<div class="nav-align-top">
  <ul class="nav nav-pills nav-fill mb-4" role="tablist">
    <li class="nav-item">
      <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-1" aria-controls="navs-pills-add-category-1" aria-selected="true"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></button>
    </li>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-2" aria-controls="navs-pills-add-category-2" aria-selected="true"><?php echo translate("tr_23994d848ac731ce5f4a0ee413ddc61a"); ?></button>
    </li>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-3" aria-controls="navs-pills-add-category-3" aria-selected="true">Seo</button>
    </li>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-4" aria-controls="navs-pills-add-category-4" aria-selected="true"><?php echo translate("tr_065a4bdc2e5a9f1a6e51aeabcf1b4e4e"); ?></button>
    </li>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-5" aria-controls="navs-pills-add-category-5" aria-selected="true"><?php echo translate("tr_6f5dbd2cd38f7a722322eaaf5c1b3ef1"); ?></button>
    </li>
    <?php if($app->settings->integration_delivery_services_active){ ?>
    <li class="nav-item">
      <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-add-category-6" aria-controls="navs-pills-add-category-6" aria-selected="true"><?php echo translate("tr_b973ee86903271172c9b4f5529bc19bb"); ?></button>
    </li>
    <?php } ?>
  </ul>
  <div class="tab-content">

    <div class="tab-pane fade show active" id="navs-pills-add-category-1" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="status" value="1" checked="" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
          </label>          
        </div>
        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>
          <?php echo $app->ui->managerFiles(["type"=>"images", "path"=>"images"]); ?>
        </div>
        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
          <input type="text" name="name" class="form-control inTranslite" />
          <label class="form-label-error" data-name="name" ></label>
        </div>
        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_32df0c52cac96c2feb95654aab7f6e5a"); ?><span class="form-label-importantly" >*</span></label>
          <input type="text" name="alias" class="form-control outTranslite" />
          <label class="form-label-error" data-name="alias" ></label>
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_c0981e606859b36e8c92c1c3d9949eff"); ?></label>
          <select name="parent_id" data-live-search="true" class="form-select selectpicker" data-live-search="true" >
            <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
            <?php echo $app->component->ads_categories->getRecursionOptions(); ?>
          </select>
        </div>

        <div class="col-12">
          <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
            <?php echo translate("tr_ad419e27246a1c8de39e4068dc322731"); ?>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_f48da5a592dacdadea3c066d6ff1f217"); ?></label>
          <select name="type_goods" class="form-select selectpicker" >
            <option value="" ><?php echo translate("tr_c0348d0766131f2450cf27548752c844"); ?></option>
            <option value="physical_goods" ><?php echo translate("tr_29181c731777219af39a69bb2f4a8c70"); ?></option>
            <option value="electronic_goods" ><?php echo translate("tr_85448eede56d6739e80120fe018005ad"); ?></option>
            <option value="services" ><?php echo translate("tr_4e1a0e95e6e3f392f99811caba17f550"); ?></option>
            <option value="event" ><?php echo translate("tr_01532143ed610c03b3469867123f2e24"); ?></option>
            <option value="realty" ><?php echo translate("tr_dcf7d3c6853de595b4f22d519e5d9dbe"); ?></option>
            <option value="transport" ><?php echo translate("tr_7bd6a076ae558d502fc4e0c96ff74fd3"); ?></option>
            <option value="partner_link" ><?php echo translate("tr_6b5d775b64e9503706984360194843b8"); ?></option>
          </select>
        </div>

      </div>

    </div>

    <div class="tab-pane fade" id="navs-pills-add-category-2" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="price_status" value="1" checked="" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?></span>
          </label>          
        </div>

        <div class="add-category-options-price-container" >

          <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_bea4456bcfa0cc3c3b3e17869851f902"); ?><span class="form-label-importantly" >*</span></label>
            <select name="price_name_id" class="form-select selectpicker" >
              <?php echo $app->component->settings->outSystemsPriceNames("option"); ?>
            </select>
          </div>

          <div class="col-12 mt-2">
            <label class="form-label" ><?php echo translate("tr_f21e5d5a36fd155d9e5eface1bf8b9b9"); ?></label>
            <select name="price_measure_ids[]" class="form-select selectpicker" multiple title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" >
              <?php echo $app->component->settings->outSystemsPriceMeasurements("option"); ?>
            </select>
          </div>

          <div class="col-12 mt-2">
            <label class="switch">
              <input type="checkbox" class="switch-input" name="price_fixed_change" value="1" checked="" >
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label" ><?php echo translate("tr_9f4b120b0fd803b9a566f836a2bdb1c2"); ?></span>
            </label>          
          </div>

          <div class="col-12 mt-2">
            <label class="switch">
              <input type="checkbox" class="switch-input" name="price_required" value="1" checked="" >
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label" ><?php echo translate("tr_a80189a50ad46f60325bc6e80a7985d1"); ?></span>
            </label>          
          </div>

        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="paid_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_c69ba92d0fcc04b5dc21d0790af2a7ae"); ?></span>
          </label>          
        </div>

        <div class="add-category-options-price-paid-container" >

          <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_4a11d5ca00624950e2589aebe6db8b14"); ?><span class="form-label-importantly" >*</span></label>

            <div class="input-group">
              <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
              <input type="number" class="form-control" name="paid_cost">
            </div>

            <label class="form-label-error" data-name="paid_cost" ></label>

          </div>

          <div class="col-12 mt-2">
            <label class="form-label" ><?php echo translate("tr_62453be1236a85a69601fa21f0d6fa5e"); ?></label>
            <input type="text" name="paid_free_count" class="form-control" />
          </div>

        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="marketplace_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_9f90e3d6d6e9fb8e3b7a6490acfdd869"); ?></span>
          </label>          
        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="secure_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_c21b2ddff1f121219f81a576c5f6a242"); ?></span>
          </label>          
        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="booking_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_c9d623907a3e082186a2cb44684740d4"); ?></span>
          </label>          
        </div>

        <div class="add-category-options-booking-container" >

          <div class="col-12">

            <label class="form-label" ><?php echo translate("tr_50a761a11275b70272b97775ec641e61"); ?></label>

            <select name="booking_action" class="form-select selectpicker" >
              <option value="booking" ><?php echo translate("tr_543c872407d0aa834e734f713afdcf33"); ?></option>
              <option value="rent" ><?php echo translate("tr_9f0bba0dacad1eacd3a9fcd80e8bd00a"); ?></option>
            </select>

          </div>

        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="change_city_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_fc267c13e52b7ec29a86da9ca0ecc661"); ?></span>
          </label>          
        </div>

        <div> <h5 class="mt-0 mb-0" ><?php echo translate("tr_a4a347795fd7676519ccc7af4ea6b586"); ?></h5> </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="gratis_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_60183c67d880a855d91a9419f344e97e"); ?></span>
          </label>          
        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="online_view_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_2d419e02a117a06a2e3da9d94cf47a92"); ?></span>
          </label>          
        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="condition_new_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_963d95509d21446ecc58963ffbc37251"); ?></span>
          </label>          
        </div>

        <div class="col-12">
          <label class="switch">
            <input type="checkbox" class="switch-input" name="condition_brand_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_d824e6a3c6b53aadef194ccec0da56e1"); ?></span>
          </label>          
        </div>

      </div>

    </div>

    <div class="tab-pane fade" id="navs-pills-add-category-3" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">
          <label class="form-label" >Meta title</label>
          <input type="text" name="seo_title" class="form-control" />
        </div>

        <div class="col-12">
          <label class="form-label" >Meta Description</label>
          <input type="text" name="seo_desc" class="form-control" />
        </div>

        <div class="col-12">
          <label class="form-label" >H1</label>
          <input type="text" name="seo_h1" class="form-control" />
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
          <textarea rows="4" class="form-control" name="seo_text" ></textarea>
        </div>

      </div>

    </div>

    <div class="tab-pane fade" id="navs-pills-add-category-4" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">

          <label class="switch">
            <input type="checkbox" class="switch-input" name="personal_page_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_6100912aeb68d0a7e35d349fe3e942a1"); ?></span>
          </label>  

        </div>

        <div class="col-12">
          <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
            <?php echo translate("tr_b056dfe880c296c096c478bf43175f29"); ?>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label" ><?php echo translate("tr_87dd40b2b20dd5bc96d6975114a54704"); ?></label>
          <select name="default_view_items_catalog" class="form-select selectpicker" >
            <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
            <option value="grid" >Grid</option>
            <option value="list" >List</option>
          </select>
        </div>

      </div>

    </div>

    <div class="tab-pane fade" id="navs-pills-add-category-5" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">

          <label class="switch">
            <input type="checkbox" class="switch-input" name="filter_generation_title" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_db8cf8be283b19e8cd4de11f44c7f2d7"); ?></span>
          </label>  

        </div>

        <div class="add-category-template-title-container" >

          <div class="col-12">

            <label class="form-label" ><?php echo translate("tr_cae7d9d0877148ec2343547a3bc4879c"); ?></label>

            <div class="input-group">
              <input type="text" name="filter_template_title" class="form-control" />
              <button class="btn btn-outline-primary waves-effect openModal" data-modal-id="filterTemplateModal" ><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></button>
            </div>

            <label class="form-label-error" data-name="filter_template_title" ></label>

          </div>

          <div class="col-12 mt-2">
            <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
             <?php echo translate("tr_a8f504db0c19906e4955881468c53429"); ?> 
            </div>
          </div>

        </div>

        <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_722390911d778dcf911e378a75d5971e"); ?></label>
            <div class="input-group">
              <input type="text" name="filter_template_preset" class="form-control" />
              <button class="btn btn-outline-primary waves-effect openModal" data-modal-id="filterTemplateModal" ><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></button>
            </div>
        </div>

        <div class="col-12 mt-2">
          <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
           <?php echo translate("tr_c9f94ad43dbba7c358fc38db3405f3b0"); ?> 
          </div>
        </div>

      </div>

    </div>

    <div class="tab-pane fade" id="navs-pills-add-category-6" role="tabpanel">

      <div class="row g-3" >

        <div class="col-12">

          <label class="switch">
            <input type="checkbox" class="switch-input" name="delivery_status" value="1" >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label" ><?php echo translate("tr_e1fec1020a745a956b67d58f4f77fc7c"); ?></span>
          </label>  

        </div>

        <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_50c4adb31ead986ad17f55cef7e71368"); ?><span class="form-label-importantly" >*</span></label>
            <input type="text" name="delivery_size_weight" class="form-control" />
            <label class="form-label-error" data-name="delivery_size_weight" ></label>
        </div>

        <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_0b3365ed791da2ed96c2ee8042483b42"); ?></label>
            <input type="text" name="delivery_size_width" class="form-control" />
        </div>

        <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_12a131ae3b8de12a099decbe7f597d0a"); ?></label>
            <input type="text" name="delivery_size_height" class="form-control" />
        </div>

        <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_c56513d32eb3877dd91d7024ab8a0bf7"); ?></label>
            <input type="text" name="delivery_size_depth" class="form-control" />
        </div>

        <div class="col-12 mt-3">
          <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
           <?php echo translate("tr_6445af90ee2c24ab4e21ff5e0e31de97"); ?> 
          </div>
        </div>

      </div>

    </div>

    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddCategory"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>

  </div>
</div>

</form>
