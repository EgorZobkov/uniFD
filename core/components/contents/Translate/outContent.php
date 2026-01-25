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