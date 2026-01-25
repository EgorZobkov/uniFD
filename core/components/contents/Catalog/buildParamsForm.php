public function buildParamsForm($params=[], $category_id=0, $only_default_filters=true){
    global $app;

    $price_from = $params["filter"]["price_from"] ?: '';
    $price_to = $params["filter"]["price_to"] ?: '';
    $priceName = '';

    if($price_from && $price_to){
        if($price_from > $price_to){
            $price_from = '';
        }
    }

    if($app->component->ads_categories->categories[$category_id]["price_name_id"]){
        $systemPrice = $app->model->system_price_names->find("id=?", [$app->component->ads_categories->categories[$category_id]["price_name_id"]]);
        if($systemPrice){
            $priceName = translateField($systemPrice->name);
        }else{
            $priceName = translate("tr_682fa8dbadd54fda355b27f124938c93");
        }
    }else{
        $priceName = translate("tr_682fa8dbadd54fda355b27f124938c93");
    }
    
    ?>

    <div class="params-form-filters-container" >

    <?php if($category_id){ ?>
        <?php if($app->component->ads_categories->categories[$category_id]["price_status"]){ ?>
        <div class="params-form-item params-form-item-price" >
            <label class="params-form-item-label" ><?php echo $priceName; ?></label>
            <div class="row" >
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_from]" placeholder="<?php echo translate("tr_996b125bc9bba860718d999df2ecc61d"); ?>" value="<?php echo $price_from; ?>" /></div>
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_to]" placeholder="<?php echo translate("tr_c2aa9c0cecea49717bb2439da36a7387"); ?>" value="<?php echo $price_to; ?>" /></div>
            </div>
        </div> 
        <?php } ?>   
    <?php }else{ ?>  
        <div class="params-form-item params-form-item-price" >
            <label class="params-form-item-label" ><?php echo translate("tr_682fa8dbadd54fda355b27f124938c93"); ?></label>
            <div class="row" >
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_from]" placeholder="<?php echo translate("tr_996b125bc9bba860718d999df2ecc61d"); ?>" value="<?php echo $price_from; ?>" /></div>
                <div class="col-6" ><input type="text" class="form-control" name="filter[price_to]" placeholder="<?php echo translate("tr_c2aa9c0cecea49717bb2439da36a7387"); ?>" value="<?php echo $price_to; ?>" /></div>
            </div>
        </div> 
    <?php } ?>          

    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][urgently]" value="1" <?php echo $params["filter"]["switch"]["urgently"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_c85cf9e96515efc35d01f5ead5495666"); ?></span>
        </label>
    </div>

    <?php if($app->component->ads_categories->categories[$category_id]["delivery_status"]){ ?>
    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][delivery]" value="1" <?php echo $params["filter"]["switch"]["delivery"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_4e049833e66e92f322fcafd7b2798f8f"); ?></span>
        </label>
    </div>
    <?php } ?>

    <?php if($app->component->ads_categories->categories[$category_id]["condition_new_status"]){ ?>
    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][only_new]" value="1" <?php echo $params["filter"]["switch"]["only_new"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_71a1870b0d47ee55459cd727e88b8b8d"); ?></span>
        </label>
    </div>
    <?php } ?>

    <?php if($app->component->ads_categories->categories[$category_id]["condition_brand_status"]){ ?>
    <div class="params-form-item params-form-item-switch" >
        <label class="switch">
          <input type="checkbox" class="switch-input" name="filter[switch][only_brand]" value="1" <?php echo $params["filter"]["switch"]["only_brand"] ? 'checked=""' : ''; ?> >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"><?php echo translate("tr_3e66cad801646a25439eb6f191565d21"); ?></span>
        </label>
    </div>
    <?php } ?>

    <?php if($app->component->ads_categories->categories[$category_id]["booking_status"]){ ?>

        <div class="params-form-item params-form-item-calendar" >
            <label class="params-form-item-label"><?php echo translate("tr_35836cab785c307eaae16002e9c2e397"); ?></label>
            <div class="params-form-item-calendar-range1" style="display: none;" ></div>
            <div class="params-form-item-calendar-range2"></div>
        </div>

        <input type="hidden" name="filter[calendar_date_start]" class="params-form-calendar-date-start" value="<?php echo $params["filter"]["calendar_date_start"]; ?>" >
        <input type="hidden" name="filter[calendar_date_end]" class="params-form-calendar-date-end" value="<?php echo $params["filter"]["calendar_date_end"]; ?>" >              

    <?php } ?>

    <?php echo $app->component->ads_filters->outFiltersByCatalog($params["filter"], $category_id, $only_default_filters); ?>

    </div>

    <?php

     if($params["sort"]){
        ?>
        <input type="hidden" name="sort" value="<?php echo $params["sort"]; ?>" >
        <?php
     }

     ?>

     <input type="hidden" name="c_id" value="<?php echo $category_id; ?>" >

     <?php

}