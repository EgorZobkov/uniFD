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