<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;
use App\Systems\Container;

class Translate
{

 public $alias = "translate";

 public function deleteColumnTables($iso=null){
    global $app;

    if($iso){

        $app->db->deleteColumn("uni_ads_categories", "name_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "alias_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_title_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_desc_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_h1_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_text_".$iso);

        $app->db->deleteColumn("uni_ads_filters", "name_".$iso);
        $app->db->deleteColumn("uni_ads_filters", "alias_".$iso);

        $app->db->deleteColumn("uni_ads_filters_items", "name_".$iso);
        $app->db->deleteColumn("uni_ads_filters_items", "alias_".$iso);

        $app->db->deleteColumn("uni_ads_filters_links", "name_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_title_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_desc_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_h1_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_text_".$iso);

        $app->db->deleteColumn("uni_blog_categories", "name_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "alias_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_title_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_desc_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_h1_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_text_".$iso);

        $app->db->deleteColumn("uni_blog_posts", "title_".$iso);
        $app->db->deleteColumn("uni_blog_posts", "alias_".$iso);
        $app->db->deleteColumn("uni_blog_posts", "content_".$iso);
        $app->db->deleteColumn("uni_blog_posts", "seo_desc_".$iso);

        $app->db->deleteColumn("uni_promo_banners", "title_".$iso);
        $app->db->deleteColumn("uni_promo_banners", "text_".$iso);

        $app->db->deleteColumn("uni_geo_cities", "name_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "seo_text_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "region_name_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "country_name_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "declension_".$iso);

        $app->db->deleteColumn("uni_geo_cities_districts", "name_".$iso);
        $app->db->deleteColumn("uni_geo_cities_metro", "name_".$iso);

        $app->db->deleteColumn("uni_geo_countries", "name_".$iso);
        $app->db->deleteColumn("uni_geo_countries", "declension_".$iso);
        $app->db->deleteColumn("uni_geo_countries", "seo_text_".$iso);

        $app->db->deleteColumn("uni_geo_regions", "name_".$iso);
        $app->db->deleteColumn("uni_geo_regions", "declension_".$iso);
        $app->db->deleteColumn("uni_geo_regions", "seo_text_".$iso);

        $app->db->deleteColumn("uni_ads_services", "name_".$iso);
        $app->db->deleteColumn("uni_ads_services", "text_".$iso);

        $app->db->deleteColumn("uni_chat_channels", "name_".$iso);
        $app->db->deleteColumn("uni_chat_channels", "text_".$iso);

        $app->db->deleteColumn("uni_users_tariffs", "name_".$iso);
        $app->db->deleteColumn("uni_users_tariffs", "text_".$iso);

        $app->db->deleteColumn("uni_users_tariffs_items", "name_".$iso);
        $app->db->deleteColumn("uni_users_tariffs_items", "text_".$iso);

        $app->db->deleteColumn("uni_search_keywords", "name_".$iso);
        $app->db->deleteColumn("uni_search_keywords", "tags_".$iso);

    }

}

public function editContent($content=[], $iso=null, $view=null){
    global $app;

    if($view == "content" || !$view){

        if($content && file_exists($app->config->storage->translations . '/' . $iso . '/content.tr')){

            $data = require $app->config->storage->translations . '/' . $iso . '/content.tr';

            foreach ($content as $key => $value) {
                if(trim($value)){
                    $data[$key] = trim($value);
                }
            }

            $data = '<?php return '.var_export($data, true).'; ?>';

            _file_put_contents($app->config->storage->translations . '/' . $iso . '/content.tr', $data);

        }

    }elseif($view == "js_content"){

        if($content && file_exists($app->config->storage->translations . '/' . $iso . '/js.tr')){

            $data = require $app->config->storage->translations . '/' . $iso . '/js.tr';

            foreach ($content as $key => $value) {
                if(trim($value)){
                    $data[$key] = trim($value);
                }
            }

            $data = '<?php return '.var_export($data, true).'; ?>';

            _file_put_contents($app->config->storage->translations . '/' . $iso . '/js.tr', $data);

        }

    }elseif($view == "app_content"){

        if($content && file_exists($app->config->storage->translations . '/' . $iso . '/app.tr')){

            $data = require $app->config->storage->translations . '/' . $iso . '/app.tr';

            foreach ($content as $key => $value) {
                if(trim($value)){
                    $data[$key] = trim($value);
                }
            }

            $data = '<?php return '.var_export($data, true).'; ?>';

            _file_put_contents($app->config->storage->translations . '/' . $iso . '/app.tr', $data);

        }

    }else{

        $fields = [];

        if($content){

            foreach ($content as $id => $nested) {
                $fields_cell = [];
                foreach ($nested as $field => $value) {
                    if(strpos($field, "alias") !== false){
                        $fields_cell[$field] = slug($value);
                    }elseif(strpos($field, "content") !== false){
                        $fields_cell[$field] = htmlspecialchars_decode($value);
                    }else{
                        $fields_cell[$field] = $value;
                    }
                }
                $fields[$id] = $fields_cell;
            }

        }

        if($fields){
            foreach ($fields as $key => $value) {
                if($view == "ads_categories"){
                    $app->model->ads_categories->update($value, $key);
                }elseif($view == "ads_filters"){
                    $app->model->ads_filters->update($value, $key);
                }elseif($view == "ads_filters_items"){
                    $app->model->ads_filters_items->update($value, $key);
                }elseif($view == "ads_filters_links"){
                    $app->model->ads_filters_links->update($value, $key);
                }elseif($view == "blog_categories"){
                    $app->model->blog_categories->update($value, $key);
                }elseif($view == "blog_posts"){
                    $app->model->blog_posts->update($value, $key);
                }elseif($view == "promo_banners"){
                    $app->model->promo_banners->update($value, $key);
                }elseif($view == "countries"){
                    $app->model->geo_countries->update($value, $key);
                }elseif($view == "cities"){
                    $app->model->geo_cities->update($value, $key);
                }elseif($view == "cities_districts"){
                    $app->model->geo_cities_districts->update($value, $key);
                }elseif($view == "cities_metro"){
                    $app->model->geo_cities_metro->update($value, $key);
                }elseif($view == "regions"){
                    $app->model->geo_regions->update($value, $key);
                }elseif($view == "ads_services"){
                    $app->model->ads_services->update($value, $key);
                }elseif($view == "chat_channels"){
                    $app->model->chat_channels->update($value, $key);
                }elseif($view == "users_tariffs"){
                    $app->model->users_tariffs->update($value, $key);
                }elseif($view == "users_tariffs_items"){
                    $app->model->users_tariffs_items->update($value, $key);
                }elseif($view == "search_keywords"){
                    $app->model->search_keywords->update($value, $key);
                }
            }
        }

    }

}

public function insertColumnTables($iso=null){
    global $app;

    if($iso){

        $app->db->insertColumnString("uni_ads_categories", "name_".$iso);
        $app->db->insertColumnString("uni_ads_categories", "alias_".$iso);
        $app->db->insertColumnString("uni_ads_categories", "seo_title_".$iso);
        $app->db->insertColumnText("uni_ads_categories", "seo_desc_".$iso);
        $app->db->insertColumnString("uni_ads_categories", "seo_h1_".$iso);
        $app->db->insertColumnText("uni_ads_categories", "seo_text_".$iso);

        $app->db->insertColumnString("uni_ads_filters", "name_".$iso);
        $app->db->insertColumnString("uni_ads_filters", "alias_".$iso);

        $app->db->insertColumnString("uni_ads_filters_items", "name_".$iso);
        $app->db->insertColumnString("uni_ads_filters_items", "alias_".$iso);

        $app->db->insertColumnString("uni_ads_filters_links", "name_".$iso);
        $app->db->insertColumnString("uni_ads_filters_links", "seo_title_".$iso);
        $app->db->insertColumnText("uni_ads_filters_links", "seo_desc_".$iso);
        $app->db->insertColumnString("uni_ads_filters_links", "seo_h1_".$iso);
        $app->db->insertColumnText("uni_ads_filters_links", "seo_text_".$iso);

        $app->db->insertColumnString("uni_blog_categories", "name_".$iso);
        $app->db->insertColumnString("uni_blog_categories", "alias_".$iso);
        $app->db->insertColumnString("uni_blog_categories", "seo_title_".$iso);
        $app->db->insertColumnText("uni_blog_categories", "seo_desc_".$iso);
        $app->db->insertColumnString("uni_blog_categories", "seo_h1_".$iso);
        $app->db->insertColumnText("uni_blog_categories", "seo_text_".$iso);

        $app->db->insertColumnString("uni_blog_posts", "title_".$iso);
        $app->db->insertColumnString("uni_blog_posts", "alias_".$iso);
        $app->db->insertColumnText("uni_blog_posts", "content_".$iso);
        $app->db->insertColumnText("uni_blog_posts", "seo_desc_".$iso);

        $app->db->insertColumnString("uni_promo_banners", "title_".$iso);
        $app->db->insertColumnString("uni_promo_banners", "text_".$iso);

        $app->db->insertColumnString("uni_geo_cities", "name_".$iso);
        $app->db->insertColumnText("uni_geo_cities", "seo_text_".$iso);
        $app->db->insertColumnString("uni_geo_cities", "region_name_".$iso);
        $app->db->insertColumnString("uni_geo_cities", "country_name_".$iso);
        $app->db->insertColumnString("uni_geo_cities", "declension_".$iso);

        $app->db->insertColumnString("uni_geo_cities_districts", "name_".$iso);
        $app->db->insertColumnString("uni_geo_cities_metro", "name_".$iso);

        $app->db->insertColumnString("uni_geo_countries", "name_".$iso);
        $app->db->insertColumnString("uni_geo_countries", "declension_".$iso);
        $app->db->insertColumnText("uni_geo_countries", "seo_text_".$iso);

        $app->db->insertColumnString("uni_geo_regions", "name_".$iso);
        $app->db->insertColumnString("uni_geo_regions", "declension_".$iso);
        $app->db->insertColumnText("uni_geo_regions", "seo_text_".$iso);

        $app->db->insertColumnString("uni_ads_services", "name_".$iso);
        $app->db->insertColumnString("uni_ads_services", "text_".$iso);

        $app->db->insertColumnString("uni_chat_channels", "name_".$iso);
        $app->db->insertColumnString("uni_chat_channels", "text_".$iso);

        $app->db->insertColumnString("uni_users_tariffs", "name_".$iso);
        $app->db->insertColumnString("uni_users_tariffs", "text_".$iso);

        $app->db->insertColumnString("uni_users_tariffs_items", "name_".$iso);
        $app->db->insertColumnString("uni_users_tariffs_items", "text_".$iso);

        $app->db->insertColumnString("uni_search_keywords", "name_".$iso);
        $app->db->insertColumnText("uni_search_keywords", "tags_".$iso);

    }

}

public function outChangeLanguages($options=[]){
    global $app;

    $class = [];

    if(!$app->settings->multi_languages_status){
        return;
    }

    if($options["align-vertical"] == "top"){
        $class[] = 'uni-dropdown-content-align-top';
    }elseif($options["align-vertical"] == "bottom"){
        $class[] = 'uni-dropdown-content-align-bottom';
    }

    if($options["align-horizontal"] == "left"){
        $class[] = 'uni-dropdown-content-align-left';
    }elseif($options["align-horizontal"] == "right"){
        $class[] = 'uni-dropdown-content-align-right';
    }

    $getLanguages = $app->model->languages->getAll("status=?", [1]);

    if($getLanguages){
        ?>
        <div class="<?php echo $options["container-class"]; ?>" >
        <div class="uni-dropdown">
          <span class="uni-dropdown-name"> <span><?php echo $app->translate->current->name; ?></span> <i class="ti ti-chevron-down"></i></span>  
          <div class="uni-dropdown-content <?php echo implode(" ", $class); ?>">
            <?php
            foreach ($getLanguages as $key => $value) {
                ?>
                <a href="<?php echo $app->translate->buildLink($value["iso"]); ?>" class="uni-dropdown-content-item" > <?php if($app->storage->name($value["image"])->exist()){  ?> <span class="uni-dropdown-content-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>"> </span> <?php } ?> <?php echo $value["name"]; ?></a>
                <?php
            }
            ?>
          </div>               
        </div>
        </div>
        <?php
    }

}

public function outContent($iso=null, $view=null){
    global $app;

    $resultSearch = [];
    $page = $_POST['page'] ?: 1;
    $output = $_POST['output'] ?: 100;

    $app->pagination->request($_POST);

    if($iso){

        if($view == "content" || !$view){

            if(file_exists($app->config->storage->translations.'/'.$iso.'/content.tr')){

                $content = require $app->config->storage->translations.'/'.$iso.'/content.tr';

                if($_POST['search']){

                    foreach ($content as $key => $value) {
                        if (str_contains($key, $_POST['search']) || str_contains($value, $_POST['search'])) {
                            $resultSearch[$key] = $value;
                        }
                    }

                    $content = $resultSearch;
                }else{
                    $content = array_reverse($content, true);
                }

                $app->pagination->page($page)->output($output)->total(count($content))->init();
                
                $offset = $app->pagination->offsetArray();

                if($content){

                    foreach (array_slice($content, $offset["start"], $offset["output"]) as $code => $value) {
                        ?>

                        <div class="mb-3" >
                            <label class="form-label" ><?php echo $code; ?></label>
                            <input type="text" name="content[<?php echo $code; ?>]" class="form-control" value="<?php echo $value; ?>" >
                        </div>

                        <?php
                    }

                }else{

                    echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

                }

            }

        }elseif($view == "js_content"){

            if(file_exists($app->config->storage->translations.'/'.$iso.'/js.tr')){

                $content = require $app->config->storage->translations.'/'.$iso.'/js.tr';

                if($_POST['search']){

                    foreach ($content as $key => $value) {
                        if (str_contains($key, $_POST['search']) || str_contains($value, $_POST['search'])) {
                            $resultSearch[$key] = $value;
                        }
                    }

                    $content = $resultSearch;
                }else{
                    $content = array_reverse($content, true);
                }

                if($content){

                    foreach ($content as $code => $value) {
                        ?>

                        <div class="mb-3" >
                            <label class="form-label" ><?php echo $code; ?></label>
                            <input type="text" name="content[<?php echo $code; ?>]" class="form-control" value="<?php echo $value; ?>" >
                        </div>

                        <?php
                    }

                }else{

                    echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

                }

            }               

        }elseif($view == "app_content"){

            if(file_exists($app->config->storage->translations.'/'.$iso.'/app.tr')){

                $content = require $app->config->storage->translations.'/'.$iso.'/app.tr';

                if($_POST['search']){

                    foreach ($content as $key => $value) {
                        if (str_contains($key, $_POST['search']) || str_contains($value, $_POST['search'])) {
                            $resultSearch[$key] = $value;
                        }
                    }

                    $content = $resultSearch;
                }else{
                    $content = array_reverse($content, true);
                }

                $app->pagination->page($page)->output($output)->total(count($content))->init();
                
                $offset = $app->pagination->offsetArray();

                if($content){

                    foreach (array_slice($content, $offset["start"], $offset["output"]) as $code => $value) {
                        ?>

                        <div class="mb-3" >
                            <label class="form-label" ><?php echo $code; ?></label>
                            <input type="text" name="content[<?php echo $code; ?>]" class="form-control" value="<?php echo $value; ?>" >
                        </div>

                        <?php
                    }

                }else{

                    echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

                }

            }               

        }elseif($view == "ads_categories"){

            $data = $app->model->ads_categories->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_2560367cdb06ce74b741050867623464"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][alias_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["alias_".$iso] ?: $value["alias"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_039892c779f28a361b2b3cd789657d2f"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_title_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_title_".$iso] ?: $value["seo_title"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_900a8e6e3cdb86216d68cf563a626ca5"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_desc_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_desc_".$iso] ?: $value["seo_desc"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_316cce9620c7cfbde61501ddcea50954"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_h1_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_h1_".$iso] ?: $value["seo_h1"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_c072de7ddfae95c7aaef50a08fa5189c"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][seo_text_<?php echo $iso; ?>]" ><?php echo $value["seo_text_".$iso] ?: $value["seo_text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "ads_filters"){

            $data = $app->model->ads_filters->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_2560367cdb06ce74b741050867623464"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][alias_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["alias_".$iso] ?: $value["alias"]; ?>" >
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "ads_filters_items"){

            $data = $app->model->ads_filters_items->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_2560367cdb06ce74b741050867623464"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][alias_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["alias_".$iso] ?: $value["alias"]; ?>" >
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "ads_filters_links"){

            $data = $app->model->ads_filters_links->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_039892c779f28a361b2b3cd789657d2f"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_title_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_title_".$iso] ?: $value["seo_title"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_900a8e6e3cdb86216d68cf563a626ca5"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_desc_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_desc_".$iso] ?: $value["seo_desc"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_316cce9620c7cfbde61501ddcea50954"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_h1_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_h1_".$iso] ?: $value["seo_h1"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_c072de7ddfae95c7aaef50a08fa5189c"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][seo_text_<?php echo $iso; ?>]" ><?php echo $value["seo_text_".$iso] ?: $value["seo_text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "blog_categories"){

            $data = $app->model->blog_categories->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_2560367cdb06ce74b741050867623464"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][alias_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["alias_".$iso] ?: $value["alias"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_039892c779f28a361b2b3cd789657d2f"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_title_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_title_".$iso] ?: $value["seo_title"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_900a8e6e3cdb86216d68cf563a626ca5"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_desc_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_desc_".$iso] ?: $value["seo_desc"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_316cce9620c7cfbde61501ddcea50954"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][seo_h1_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["seo_h1_".$iso] ?: $value["seo_h1"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_c072de7ddfae95c7aaef50a08fa5189c"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][seo_text_<?php echo $iso; ?>]" ><?php echo $value["seo_text_".$iso] ?: $value["seo_text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "blog_posts"){

            $data = $app->model->blog_posts->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][title_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["title_".$iso] ?: $value["title"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_2560367cdb06ce74b741050867623464"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][alias_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["alias_".$iso] ?: $value["alias"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_900a8e6e3cdb86216d68cf563a626ca5"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][seo_desc_<?php echo $iso; ?>]" ><?php echo $value["seo_desc_".$iso] ?: $value["seo_desc"]; ?></textarea>
                        <label class="form-label mt-2" ><?php echo translate("tr_480107c7e081f07e1a616b3e98a1bc89"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][content_<?php echo $iso; ?>]" ><?php echo $value["content_".$iso] ?: $value["content"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "promo_banners"){

            $data = $app->model->promo_banners->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][title_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["title_".$iso] ?: $value["title"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][text_<?php echo $iso; ?>]" ><?php echo $value["text_".$iso] ?: $value["text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "countries"){

            $data = $app->model->geo_countries->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_d2af44591aef5ad60899f4904a9ce047"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][declension_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["declension_".$iso] ?: $value["declension"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_c072de7ddfae95c7aaef50a08fa5189c"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][seo_text_<?php echo $iso; ?>]" ><?php echo $value["seo_text_".$iso] ?: $value["seo_text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "regions"){

            $data = $app->model->geo_regions->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_d2af44591aef5ad60899f4904a9ce047"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][declension_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["declension_".$iso] ?: $value["declension"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_c072de7ddfae95c7aaef50a08fa5189c"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][seo_text_<?php echo $iso; ?>]" ><?php echo $value["seo_text_".$iso] ?: $value["seo_text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "cities"){

            $data = $app->model->geo_cities->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_d2af44591aef5ad60899f4904a9ce047"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][declension_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["declension_".$iso] ?: $value["declension"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_5a81e30326581b91ef0b95a2ab48688a"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][region_name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["region_name_".$iso] ?: $value["region_name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_9c6a617e16e807523c8505ffcbb3a026"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][country_name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["country_name_".$iso] ?: $value["country_name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_c072de7ddfae95c7aaef50a08fa5189c"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][seo_text_<?php echo $iso; ?>]" ><?php echo $value["seo_text_".$iso] ?: $value["seo_text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "cities_districts"){

            $data = $app->model->geo_cities_districts->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "cities_metro"){

            $data = $app->model->geo_cities_metro->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "ads_services"){

            $data = $app->model->ads_services->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][text_<?php echo $iso; ?>]" ><?php echo $value["text_".$iso] ?: $value["text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "chat_channels"){

            $data = $app->model->chat_channels->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][text_<?php echo $iso; ?>]" ><?php echo $value["text_".$iso] ?: $value["text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "users_tariffs"){

            $data = $app->model->users_tariffs->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][text_<?php echo $iso; ?>]" ><?php echo $value["text_".$iso] ?: $value["text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "users_tariffs_items"){

            $data = $app->model->users_tariffs_items->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][text_<?php echo $iso; ?>]" ><?php echo $value["text_".$iso] ?: $value["text"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }elseif($view == "search_keywords"){

            $data = $app->model->search_keywords->pagination(true)->page($page)->output($output)->search($_POST['search'])->getAll();

            if($data){

                foreach ($data as $key => $value) {
                    
                    ?>

                    <div class="mb-3 bg-lighter rounded p-3 position-relative" >
                        <div class="d-flex align-items-center mb-3">
                          <h5 class="mb-0 me-3"><?php echo $value["name"]; ?></h5>
                        </div>
                        <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
                        <input type="text" name="content[<?php echo $value["id"]; ?>][name_<?php echo $iso; ?>]" class="form-control" value="<?php echo $value["name_".$iso] ?: $value["name"]; ?>" >
                        <label class="form-label mt-2" ><?php echo translate("tr_54f067a401b1d97fb64ed2e6767094e0"); ?></label>
                        <textarea class="form-control" name="content[<?php echo $value["id"]; ?>][tags_<?php echo $iso; ?>]" ><?php echo $value["tags_".$iso] ?: $value["tags"]; ?></textarea>
                    </div>

                    <?php

                }

            }else{

                echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search']]);

            }               

        }

    }
    
}

public function outContentSections($iso=null, $view=null){
    global $app;

    ?>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=content'; ?>" class="nav-link <?php if($view == "content" || !$view){ echo 'active'; } ?>">
            <?php echo translate("tr_a19a091b2bf0c6a0423f2fe15671722d"); ?>
          </a>
        </li>
       
        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=js_content'; ?>" class="nav-link <?php if($view == "js_content"){ echo 'active'; } ?>">
            <?php echo translate("tr_8f8a71d6451f02bc3913403653cd8c95"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=app_content'; ?>" class="nav-link <?php if($view == "app_content"){ echo 'active'; } ?>">
            <?php echo translate("tr_f7d347aed39d6f04054946d6d3f7a271"); ?>
          </a>
        </li>

        <?php if($iso != $app->settings->default_language){ ?>
        
        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_categories'; ?>" class="nav-link <?php if($view == "ads_categories"){ echo 'active'; } ?>">
            <?php echo translate("tr_e00f391c7735dc851cfed26cbd6bbfb7"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_filters'; ?>" class="nav-link <?php if($view == "ads_filters"){ echo 'active'; } ?>">
            <?php echo translate("tr_b121cf19e04e19e70d3b978bf15f3fa7"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_filters_items'; ?>" class="nav-link <?php if($view == "ads_filters_items"){ echo 'active'; } ?>">
            <?php echo translate("tr_2a340cb64902526fa819822f2c047d6c"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_filters_links'; ?>" class="nav-link <?php if($view == "ads_filters_links"){ echo 'active'; } ?>">
            <?php echo translate("tr_dde44fa4446610dd00d07c25ce84aada"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=blog_categories'; ?>" class="nav-link <?php if($view == "blog_categories"){ echo 'active'; } ?>">
            <?php echo translate("tr_4c239493d16523d932847244c80c028a"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=blog_posts'; ?>" class="nav-link <?php if($view == "blog_posts"){ echo 'active'; } ?>">
            <?php echo translate("tr_40479311ccd23f5d64eb927684429cbb"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=promo_banners'; ?>" class="nav-link <?php if($view == "promo_banners"){ echo 'active'; } ?>">
            <?php echo translate("tr_369c5894a00530143785ee61375995ea"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_services'; ?>" class="nav-link <?php if($view == "ads_services"){ echo 'active'; } ?>">
            <?php echo translate("tr_7b1c170a6d767f68a49d7e9b001047a3"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=chat_channels'; ?>" class="nav-link <?php if($view == "chat_channels"){ echo 'active'; } ?>">
            <?php echo translate("tr_1145940bfe5eafc4ef72e793bd2593f0"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=users_tariffs'; ?>" class="nav-link <?php if($view == "users_tariffs"){ echo 'active'; } ?>">
            <?php echo translate("tr_a49106cadab8ae1ff6a37e7ccea9c665"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=users_tariffs_items'; ?>" class="nav-link <?php if($view == "users_tariffs_items"){ echo 'active'; } ?>">
            <?php echo translate("tr_bb9c3b7210bf05f8336e0d074433e5c6"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=countries'; ?>" class="nav-link <?php if($view == "countries"){ echo 'active'; } ?>">
            <?php echo translate("tr_f492287bd5434c17eca5eac67c5ad4c4"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=regions'; ?>" class="nav-link <?php if($view == "regions"){ echo 'active'; } ?>">
            <?php echo translate("tr_81b8d9aded466a2ad70e6dcdd34d22a2"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=cities'; ?>" class="nav-link <?php if($view == "cities"){ echo 'active'; } ?>">
            <?php echo translate("tr_e4775a4f4afed1b72fd3a52a9545e3cf"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=cities_districts'; ?>" class="nav-link <?php if($view == "cities_districts"){ echo 'active'; } ?>">
            <?php echo translate("tr_73d7050e5b86bed85fdc6182c27b7d59"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=cities_metro'; ?>" class="nav-link <?php if($view == "cities_metro"){ echo 'active'; } ?>">
            <?php echo translate("tr_3b0b18d398bb3870f3453f78fa021ada"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=search_keywords'; ?>" class="nav-link <?php if($view == "search_keywords"){ echo 'active'; } ?>">
            <?php echo translate("tr_bfc95980634bf529e8a406db2c842b31"); ?>
          </a>
        </li>

        <?php } ?>

    <?php

}

public function outLanguagesOptions($iso=null){
    global $app;

    $get = $app->model->languages->getAll();
    if($get){
        foreach ($get as $key => $value) {
            if($iso == $value["iso"]){
                ?>
                <option value="<?php echo $value["iso"]; ?>" selected="" ><?php echo $value["name"]; ?></option>
                <?php
            }else{
                ?>
                <option value="<?php echo $value["iso"]; ?>" ><?php echo $value["name"]; ?></option>
                <?php                    
            }
        }
    }

}

public function outLanguagesSections($iso=null, $route=null){
    global $app;

    $getLanguages = $app->model->languages->getAll();

    if($getLanguages){

        ?>

        <div class="nav-align-top mb-4">
          <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
              <?php
                foreach ($getLanguages as $key => $value) {
                    if($iso == $value["iso"]){
                        ?>
                        <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="<?php echo $route; ?>?iso=<?php echo $value["iso"]; ?>"><?php echo $value["name"]; ?></a></li>
                        <?php
                    }else{
                        ?>
                        <li class="nav-item"><a class="nav-link waves-effect waves-light" href="<?php echo $route; ?>?iso=<?php echo $value["iso"]; ?>"><?php echo $value["name"]; ?></a></li>
                        <?php                    
                    }
                }
              ?>
          </ul>
        </div>

        <?php

    }

}

public function setMainIso($iso=null){
    global $app;

    if($iso){

        $this->deleteColumnTables($iso);

        $langs = $app->model->languages->getAll("iso!=?", [$iso]);

        if($langs){
            foreach ($langs as $key => $value) {
                $this->insertColumnTables($value["iso"]);
            }
        }

    }

}



}