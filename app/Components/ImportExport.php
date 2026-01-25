<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

class ImportExport
{

 public $alias = "import_export";

 public function addLog($import_id=0, $message=null){
    global $app;

    if(isset($message)){
        $name = "import_".md5($import_id).'.txt';
        _file_put_contents($app->config->storage->logs.'/'.$name, $app->datetime->getDate().": ".$message."\n", FILE_APPEND);         
    }

}

public function allStatuses(){
    return [
        0 => translate("tr_017d8732fe062c99eb47cf54f2c7eb08"),
        1 => translate("tr_c665d401097529f7f09717764178123b"),
        2 => translate("tr_848a83b00a92e5664b4af49d35661a50"),
        3 => translate("tr_c6fd3c6a629b51b28c19e8495994f4ca"),
        4 => translate("tr_2c05df583b3c558dc0996ab453f62243"),
        5 => translate("tr_be68dffdb4af0ae31056c5b4dc513cab"),
    ];
}

public function availableTables(){
    return [
        "users" => translate("tr_b8c4e70da7bea88961184a1c1be9cb13"),
        "blog_posts" => translate("tr_02b87e1224c08281458641f896ced39d"),
        "ads" => translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"),
    ];
}

public function buildFeed($id=0){
    global $app;

    $feed = $app->model->import_export_feeds->find("id=?", [$id]);

    if($feed){

        $limit = $feed->count_upload_items ?: 1000;

        if($feed->category_id){

            $categories_ids = $app->component->ads_categories->joinId($feed->category_id)->getParentIds($feed->category_id);

            $data = $app->model->ads_data->sort("id desc limit ".$limit)->getAll("status=? and category_id IN (".$categories_ids.")", [1]);

        }else{

            $data = $app->model->ads_data->sort("id desc limit ".$limit)->getAll("status=?", [1]);

        }

        if($data){

            if($feed->feed_format == "json"){

                $result = [];

                foreach ($data as $key => $value) {

                    $value = $app->component->ads->getDataByValue($value);

                    $result["id"] = $value->id;
                    $result["title"] = $value->title;
                    $result["article_number"] = $value->article_number;
                    $result["text"] = $value->text;
                    $result["currency_code"] = $value->currency_code;
                    $result["price"] = $value->price;
                    $result["old_price"] = $value->old_price;
                    $result["category_id"] = $value->category_id;
                    $result["category_name"] = $value->category->name;
                    $result["delivery_status"] = $value->delivery_status;
                    $result["total_rating"] = $value->total_rating;
                    
                    if($feed->utm_data){
                        $url = $app->component->ads->buildAliasesAdCard($value) . '?' . $feed->utm_data;
                    }else{
                        $url = $app->component->ads->buildAliasesAdCard($value);
                    }

                    $result["link"] = $url;

                    if($value->media->images->all){
                        foreach ($value->media->images->all as $link) {
                           $result["images"][] = $link;
                        }
                    }

                    if($feed->out_filters_status){
                        $property = $app->component->ads_filters->outPropertyAd($value->id, [], true);
                        if($property){
                            foreach ($property as $filter_key => $filter_value) {
                                $result["filters"][$filter_key] = $filter_value;
                            }
                        }
                    }

                }

                _file_put_contents($app->config->storage->files_import_export.'/'.$feed->filename, _json_encode($result));

            }else{
                _file_put_contents($app->config->storage->files_import_export.'/'.$feed->filename, $this->buildXml($data, $feed));
            }

        }

    }

}

public function buildLinksImagesAds($images=null){
    global $app;

    $result = [];
    $inline = [];

    $images = explode(",", $images);

    if($images){

        foreach ($images as $key => $value) {
            if($value){
                $inline[] = ["type"=>"image", "link"=>$value];
            }
        }

        if($inline){

            foreach ($inline as $key => $value) {

               $result["images"][] = ["link"=>$value["link"]]; 
               $result["inline"][$value["link"]] = ["type"=>"image", "link"=>$value["link"]]; 

            }

        }

    }

    return $result ? _json_encode($result) : [];

}

public function buildXml($data=[], $feed=[]){
    global $app;

    $result = '';

    if($feed->feed_format == "yandex_yml"){

        $result = '<yml_catalog date="'.$app->datetime->format("Y-m-d H:i")->getDate().'">';
        $result .= '<shop>';

        $result .= '<url>'.getHost().'</url>';
        $result .= '<name>'.$feed->shop_title.'</name>';
        $result .= '<company>'.$feed->shop_company_name.'</company>';
        $result .= '<phone>'.$feed->shop_contact_phone.'</phone>';

        $result .= '<currencies>';
        $result .= '<currency id="'.$app->settings->system_default_currency.'" rate="1"/>';
        $result .= '</currencies>';

        $result .= '<categories>';

        $categories = $app->model->ads_categories->getAll("status=?", [1]);
        if($categories){

            foreach ($categories as $key => $value) {
                if($value["parent_id"]){
                    $result .= '<category id="'.$value["id"].'" parentId="'.$value["parent_id"].'" >'.addslashes(str_replace("&","-",$value["name"])).'</category>';
                }else{
                    $result .= '<category id="'.$value["id"].'" >'.addslashes(str_replace("&","-",$value["name"])).'</category>';
                }
            }

        }

        $result .= '</categories>';

        $result .= '<offers>';

        foreach ($data as $key => $value) {

            $value = $app->component->ads->getDataByValue($value);

            if($feed->utm_data){
                $url = $app->component->ads->buildAliasesAdCard($value) . '?' . $feed->utm_data;
            }else{
                $url = $app->component->ads->buildAliasesAdCard($value);
            }
            
            $result .= '
                <offer id="'.$value->id.'" available="true">
                <name>'.$value->title.'</name>
                <vendorCode>'.$value->id.'</vendorCode>
                <url>'.$url.'</url>
                <currencyId>'.$value->currency_code.'</currencyId>
                <categoryId>'.$value->category_id.'</categoryId>
                <price>'.$value->price.'</price>
            ';

            if($value->old_price){
                $result .= '
                    <oldprice>'.$value->old_price.'</oldprice>
                ';
            }

            if($value->media->images->all){
                foreach ($value->media->images->all as $link) {
                   $result .= '<picture>'.$link.'</picture>';
                }
            }

            if($feed->out_filters_status){
                $property = $app->component->ads_filters->outPropertyAd($value->id, [], true);
                if($property){
                    foreach ($property as $filter_key => $filter_value) {
                        $result .= '<param name="'.$filter_key.'">'.$filter_value.'</param>';
                    }
                }
            }

            $result .= '
                <description>
                <![CDATA['.$value->text.']]>
                </description>
                </offer>
            ';


        }

        $result .= '</offers>';

        $result .= '</shop>';
        $result .= '</yml_catalog>';

    }elseif($feed->feed_format == "google_merchant"){

        $result = '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">';

        $result .= '<title>'.$feed->shop_title.'</title>';
        $result .= '<link>'.getHost().'</link>';
        $result .= '<updated>'.$app->datetime->format("Y-m-d H:i")->getDate().'</updated>';

        foreach ($data as $key => $value) {

            $value = $app->component->ads->getDataByValue($value);

            if($feed->utm_data){
                $url = $app->component->ads->buildAliasesAdCard($value) . '?' . $feed->utm_data;
            }else{
                $url = $app->component->ads->buildAliasesAdCard($value);
            }
            
            $result .= '
                <entry>
                <g:title>'.$value->title.'</g:title>
                <g:id>'.$value->id.'</g:id>
                <g:link>'.$url.'</g:link>
                <g:availability>in stock</g:availability>
                <g:google_product_category>Furniture >'.$value->category->name.'</g:google_product_category>
            ';

            if($value->old_price){
                $result .= '
                    <g:price>'.$value->old_price.' '.$value->currency_code.'</g:price>
                    <g:sale_price>'.$value->price. ' '.$value->currency_code.'</g:sale_price>
                ';                
            }else{
                $result .= '
                    <g:price>'.$value->price.' '.$value->currency_code.'</g:price>
                ';                 
            }

            if($value->media->images->all){
                foreach ($value->media->images->all as $link) {
                   $result .= '<g:image_link>'.$link.'</g:image_link>';
                }
            }

            if($feed->out_filters_status){
                $property = $app->component->ads_filters->outPropertyAd($value->id, [], true);
                if($property){

                    $result .= '<g:product_detail>';

                    foreach ($property as $filter_key => $filter_value) {
                        $result .= '
                            <g:attribute_name>'.$filter_key.'</g:attribute_name>
                            <g:attribute_value>'.$filter_value.'</g:attribute_value>
                        ';
                    }

                    $result .= '</g:product_detail>';

                }
            }

            $result .= '
                <g:description>
                <![CDATA['.$value->text.']]>
                </g:description>
                </entry>
            ';


        }

        $result .= '</feed>';

    }

    return $result;

}

public function dataComparisonAndImport($data=[], $fields=[], $update=false){
    global $app;

    $result = [];
    $errors = [];
    $ad = [];
    $user_id = 0;
    $city_id = 0;
    $category_id = 0;
    $paramsData = isset($data["params"]) ? _json_decode($data["params"]) : [];
    $fields_table = $this->fieldsTable($data["table"]);

    if($data && $fields && $paramsData){

        if($data["table"] == "ads"){

            foreach ($fields as $key => $value) {

                if($paramsData["fields"]["title"] == $key){ $result["title"] = trim($value); }
                if($paramsData["fields"]["price"] == $key){ $result["price"] = trim($value); }
                if($paramsData["fields"]["old_price"] == $key){ $result["old_price"] = trim($value); }
                if($paramsData["fields"]["images"] == $key){ $result["images"] = trim($value); }
                if($paramsData["fields"]["text"] == $key){ $result["text"] = trim($value); }
                if($paramsData["fields"]["date"] == $key){ $result["date"] = trim($value); }
                if($paramsData["fields"]["category"] == $key){ $result["category"] = trim($value); }
                if($paramsData["fields"]["in_stock"] == $key){ $result["in_stock"] = trim($value); }
                if($paramsData["fields"]["link_video"] == $key){ $result["link_video"] = trim($value); }
                if($paramsData["fields"]["external_content"] == $key){ $result["external_content"] = trim($value); }
                if($paramsData["fields"]["partner_link"] == $key){ $result["partner_link"] = trim($value); }
                if($paramsData["fields"]["city"] == $key){ $result["city"] = trim($value); }
                if($paramsData["fields"]["region"] == $key){ $result["region"] = trim($value); }
                if($paramsData["fields"]["filter"] == $key){ $result["filter"] = trim($value); }
                if($paramsData["fields"]["address_latitude"] == $key){ $result["address_latitude"] = trim($value); }
                if($paramsData["fields"]["address_longitude"] == $key){ $result["address_longitude"] = trim($value); }
                if($paramsData["fields"]["contact_name"] == $key){ $result["contact_name"] = trim($value); }
                if($paramsData["fields"]["contact_surname"] == $key){ $result["contact_surname"] = trim($value); }
                if($paramsData["fields"]["contact_phone"] == $key){ $result["contact_phone"] = trim($value); }
                if($paramsData["fields"]["contact_email"] == $key){ $result["contact_email"] = trim($value); }
                if($paramsData["fields"]["import_item_id"] == $key){ $result["import_item_id"] = trim($value); }
                
            }

            if($result){

                if($result["import_item_id"]){
                    $ad = $app->model->ads_data->find("import_item_id=? and import_id=?", [$result["import_item_id"], $data["id"]]);
                }

                if(!$ad){

                    if(!trim($result["title"])){
                        $errors[] = translate("tr_057300f3a6ae1ac1288c1f3d0d92f4d5");
                    }elseif(!trim($result["text"])){
                        $errors[] = translate("tr_94e212c1ee775cf0d07dde374efb4d78");
                    }

                    if($paramsData["city_auto"]){

                        if(trim($result["city"]) && trim($result["region"])){
                            $getCity = $app->model->geo_cities->find("name=? and region_name=?", [trim($result["city"]), trim($result["region"])]);
                            if($getCity){
                                $city_id = $getCity->id;
                            }
                        }

                    }else{
                        $city_id = $paramsData["city_id"];
                    }

                    if($paramsData["user_reg"]){

                        if(!trim($result["contact_name"])){
                            $errors[] = translate("tr_9f28549fa7d5099affe70c481f38b8be");
                        }elseif(!trim($result["contact_phone"])){
                            $errors[] = translate("tr_053c97bc2f9cfef167aded2ee183c957");
                        }

                    }else{
                        $user_id = $paramsData["user_id"];
                    }

                    if($paramsData["category_auto"]){

                        if(trim($result["category"])){

                            if(strpos(trim($result["category"]), "|") !== false){

                                $explode_category = explode("|", trim($result["category"]));

                                if(count($explode_category) >= 2){

                                    $end_name_category = $explode_category[count($explode_category)-1];
                                    $penultimate_name_category = $explode_category[count($explode_category)-2];
                                    
                                    $getCategories = $app->model->ads_categories->getAll("name=?", [$end_name_category]);

                                    if($getCategories){

                                        foreach ($getCategories as $cat_value) {
                                            
                                            $getCategory = $app->model->ads_categories->find("id=? and name=?", [$cat_value["parent_id"], $penultimate_name_category]);

                                            if($getCategory){
                                                $category_id = $cat_value["id"];
                                                break;
                                            }

                                        }

                                    }

                                }

                                if(!$category_id){
                                    $errors[] = translate("tr_d502d66a9145993fae0678d0396687bb");
                                }

                            }elseif(intval($result["category"])){

                                $getCategory = $app->model->blog_categories->find("id=?", [intval($result["category"])]);
                                if($getCategory){
                                    $category_id = $getCategory->id;
                                }else{
                                    $errors[] = translate("tr_64d6945e074f23091202ba876d53b26e");
                                }

                            }else{

                                $getCategory = $app->model->blog_categories->find("name=?", [trim($result["category"])]);
                                if($getCategory){
                                    $category_id = $getCategory->id;
                                }else{
                                    $errors[] = translate("tr_97c1869be5a30a4dcbf7877f2f1f5070");
                                }

                            }
                            
                        }

                    }else{
                        if($paramsData["category_id"]){
                            $category_id = $paramsData["category_id"];
                        }else{
                            $errors[] = translate("tr_79341b0c3296b10149c99d29bc55e263");
                        }
                    }
                    
                    if(!$errors){

                        if($paramsData["image_download"]){
                            $result["images"] = $this->uploadImagesAds($result["images"], $paramsData["image_count_download"] ?: 5);
                        }else{
                            $result["images"] = $this->buildLinksImagesAds($result["images"]);
                        }

                        if($paramsData["only_photos"]){
                            if(!$result["images"]){
                                $errors[] = translate("tr_65109552db266f5841336023201b4879");
                            }
                        }

                    }

                    if(!$errors){

                        if(!$user_id){
                            $findUser = $app->model->users->find("email=? or phone=?", [$result["contact_email"],$result["contact_phone"]]);
                            if(!$findUser){
                                $user_id = $app->user->params(["status"=>1, "name"=>$result["contact_name"] ?: null, "surname"=>$result["contact_surname"] ?: null, "email"=>$result["contact_email"] ?: null, "phone"=>$result["contact_phone"] ?: null, "import_id"=>$data["id"]])->add();
                            }else{
                                $user_id = $findUser->id;
                            }
                        }

                        $result["filter"] = $app->component->ads_filters->buildIdsByNames($result["filter"]);

                        $app->component->ads->publicationByImport(["title"=>$result["title"] ?: null, "price"=>$result["price"] ?: 0, "old_price"=>$result["old_price"] ?: 0, "category_id"=>$category_id, "text"=>$result["text"] ?: null, "date"=>$result["date"] ?: null, "in_stock"=>$result["in_stock"], "link_video"=>$result["link_video"] ?: null, "external_content"=>$result["external_content"] ?: null, "partner_link"=>$result["partner_link"] ?: null, "geo_address_latitude"=>$result["address_latitude"] ?: null, "geo_address_longitude"=>$result["address_longitude"] ?: null, "auto_renewal"=>$result["auto_renewal"], "geo_city_id"=>$city_id, "user_id"=>$user_id, "contact_name"=>$result["contact_name"] ?: null, "contact_phone"=>$result["contact_phone"] ?: null, "contact_email"=>$result["contact_email"] ?: null, "import_id"=>$data["id"], "media"=>$result["images"] ?: null, "filter"=>$result["filter"] ?: null, "import_item_id"=>$result["import_item_id"]]);
                    }

                }else{

                    $update_fields = [];

                    if($update){

                        if($paramsData["update_fields"]){
                            foreach ($paramsData["update_fields"] as $key => $value) {

                                if($result[$value]){

                                    if($value == "title"){
                                        if($ad->title != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "price"){
                                        $result[$value] = preg_replace('/\s+/', '', $result[$value]);
                                        if($ad->price != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "old_price"){
                                        $result[$value] = preg_replace('/\s+/', '', $result[$value]);
                                        if($ad->old_price != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "text"){
                                        if($ad->text != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "in_stock"){
                                        $result[$value] = preg_replace('/\s+/', '', $result[$value]);
                                        if($ad->in_stock != $result[$value]){
                                            $update_fields[$value] = (int)$result[$value];
                                        }
                                    }

                                }

                            }
                        }

                        if($update_fields){
                            $update_fields["time_update"] = $app->datetime->getDate();
                            $app->model->ads_data->update($update_fields, $ad->id);
                            $this->addLog($data["id"], 'Update: №'.$ad->article_number.', fields: '._json_encode($update_fields));
                        }

                    }

                }

            }else{
                $errors[] = translate("tr_3ddf0b144ffb3e2a5d2d2580d689ee3e");
            }

            if($errors){
                $this->addLog($data["id"], implode(",", $errors));
            }

            return count($errors);

        }elseif($data["table"] == "users"){

            foreach ($fields as $key => $value) {

                if($paramsData["fields"]["name"] == $key){ $result["name"] = trim($value); }
                if($paramsData["fields"]["surname"] == $key){ $result["surname"] = trim($value); }
                if($paramsData["fields"]["email"] == $key){ $result["email"] = trim($value); }
                if($paramsData["fields"]["phone"] == $key){ $result["phone"] = trim($value); }
                if($paramsData["fields"]["avatar"] == $key){ $result["avatar"] = trim($value); }
                if($paramsData["fields"]["password"] == $key){ $result["password"] = trim($value); }
                if($paramsData["fields"]["balance"] == $key){ $result["balance"] = trim($value); }
                if($paramsData["fields"]["organization_name"] == $key){ $result["organization_name"] = trim($value); }

            } 

            if($result){

                if(!trim($result["name"])){
                    $errors[] = translate("tr_fe79ce33b28b1861636d9686e91b9dde");
                }elseif(!trim($result["email"])){
                    $errors[] = translate("tr_315ac6d9f14dfa4bff167979bc6245a6");
                }
                
                if(!$errors){
                    $app->user->params(["status"=>1, "name"=>$result["name"] ?: null, "surname"=>$result["surname"] ?: null, "email"=>$result["email"] ?: null, "phone"=>$result["phone"] ?: null, "avatar"=>$result["avatar"] ?: null, "import_id"=>$data["id"], "password"=>$result["password"] ?: null, "balance"=>$result["balance"] ? round($result["balance"], 2) : 0, "organization_name"=>$result["organization_name"] ?: null, "user_status"=>$result["organization_name"] ? 'company' : 'user'])->add();
                }
                
            }else{
                $errors[] = translate("tr_3ddf0b144ffb3e2a5d2d2580d689ee3e");
            }

            if($errors){
                $this->addLog($data["id"], implode(",", $errors));
            }

            return count($errors);

        }elseif($data["table"] == "blog_posts"){

            foreach ($fields as $key => $value) {

                if($paramsData["fields"]["title"] == $key){ $result["title"] = trim($value); }
                if($paramsData["fields"]["content"] == $key){ $result["content"] = trim($value); }
                if($paramsData["fields"]["category"] == $key){ $result["category"] = trim($value); }
                if($paramsData["fields"]["image"] == $key){ $result["image"] = trim($value); }
                if($paramsData["fields"]["alias"] == $key){ $result["alias"] = trim($value); }

            } 

            if($result){

                if(!trim($result["title"])){
                    $errors[] = translate("tr_057300f3a6ae1ac1288c1f3d0d92f4d5");
                }elseif(!trim($result["content"])){
                    $errors[] = translate("tr_94e212c1ee775cf0d07dde374efb4d78");
                }

                if(!$paramsData["category_id"]){

                    if(trim($result["category"])){

                        if(strpos(trim($result["category"]), "|") !== false){

                            $explode_category = explode("|", trim($result["category"]));

                            if(count($explode_category) >= 2){

                                $end_name_category = $explode_category[count($explode_category)-1];
                                $penultimate_name_category = $explode_category[count($explode_category)-2];
                                
                                $getCategories = $app->model->blog_categories->getAll("name=?", [$end_name_category]);

                                if($getCategories){

                                    foreach ($getCategories as $cat_value) {
                                        
                                        $getCategory = $app->model->blog_categories->find("id=? and name=?", [$cat_value["parent_id"], $penultimate_name_category]);

                                        if($getCategory){
                                            $category_id = $cat_value["id"];
                                            break;
                                        }

                                    }

                                }

                            }

                            if(!$category_id){
                                $errors[] = translate("tr_d502d66a9145993fae0678d0396687bb");
                            }

                        }elseif(intval($result["category"])){

                            $getCategory = $app->model->blog_categories->find("id=?", [intval($result["category"])]);
                            if($getCategory){
                                $category_id = $getCategory->id;
                            }else{
                                $errors[] = translate("tr_64d6945e074f23091202ba876d53b26e");
                            }

                        }else{

                            $getCategory = $app->model->blog_categories->find("name=?", [trim($result["category"])]);
                            if($getCategory){
                                $category_id = $getCategory->id;
                            }else{
                                $errors[] = translate("tr_97c1869be5a30a4dcbf7877f2f1f5070");
                            }

                        }
                        
                    }

                }else{
                    if($paramsData["category_id"]){
                        $category_id = $paramsData["category_id"];
                    }else{
                        $errors[] = translate("tr_79341b0c3296b10149c99d29bc55e263");
                    }
                }
                
                if(!$errors){

                    if(!isJson($result["content"])){
                        $result["content"] = _json_encode([["text"=>$result["content"]]]);
                    }

                    $result["alias"] = $result["alias"] ? slug($result["alias"]) : slug($result["title"]);

                    if($paramsData["image_download"]){
                        if($result["image"]){
                            $result["image"] = $this->uploadImages($result["image"], $app->config->storage->blog, 1)[0];
                        }
                    }

                    $app->model->blog_posts->insert(["status"=>1, "time_create"=>$app->datetime->getDate(), "title"=>$result["title"] ?: null, "image"=>$result["image"] ?: null, "category_id"=>$category_id, "content"=>$result["content"] ?: null, "alias"=>$result["alias"] ?: null, "import_id"=>$data["id"]]);
                }
                
            }else{
                $errors[] = translate("tr_3ddf0b144ffb3e2a5d2d2580d689ee3e");
            }

        }
       
    }

    if($errors){
        $this->addLog($data["id"], implode(",", $errors));
    }

    return count($errors);

}

public function delete($id=0){
    global $app;

    $data = $app->model->import_export->find("id=?",[$id]);

    $app->storage->name($data->filename)->path('files-import-export')->delete();
    $app->model->import_export->delete("id=?",[$id]);

}

public function deleteByData($data=null){
    global $app;

    if($data["table"] == "ads"){
        $app->component->ads->deleteByImport($data["id"], 5000);  
        $app->user->deleteByImport($data["id"], 5000);
        $countAds = $app->model->ads_ids->count('import_id=?', [$data["id"]]);    
        $countUsers = $app->model->users->count('import_id=?', [$data["id"]]);
        if(!$countAds && !$countUsers){
            $this->delete($data["id"]);
        }      
    }elseif($data["table"] == "ads_categories"){
        $app->component->ads_categories->deleteByImport($data["id"], 5000);
        $countCategories = $app->model->ads_categories->count('import_id=?', [$data["id"]]);    
        if(!$countCategories){
            $this->delete($data["id"]);
        }      
    }

}

public function deleteFeed($id=0){
    global $app;

    $data = $app->model->import_export_feeds->find("id=?", [$id]);

    if($data){
        $app->model->import_export_feeds->delete("id=?", [$id]);
        unlink($app->config->storage->files_import_export.'/'.$data->filename);
    }

}

public function fieldsTable($table=null){
    global $app;
    if($table == "ads"){
        return [
            "title" => translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"),
            "text" => translate("tr_38ca0af80cd7bd241500e81ba2e6efff"),
            "price" => translate("tr_682fa8dbadd54fda355b27f124938c93"),
            "old_price" => translate("tr_206948fb3ef1bd8a92285aee29a5b2f5"),
            'images' => translate("tr_67d53f4b12586c176055108451bb8355"),
            'date' => translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"),
            'address_latitude' => translate("tr_769eabf0ad4b72ec26d2e76cdb1127c5"),
            'address_longitude' => translate("tr_619e23078b3d35f39774194cc2e91db2"),
            'in_stock' => translate("tr_35044955818867ca2693fd49107c721c"),
            'link_video' => translate("tr_2bc5310f23302c852c02348e3dafe75a"),
            'external_content' => translate("tr_9bfe38a47c6f9d42c629749e32299add"),
            'partner_link' => translate("tr_6b5d775b64e9503706984360194843b8"),
            "category" => translate("tr_c95a1e2de00ee86634e177aecca00aed"),
            "city" => translate("tr_069c9cb17c0aca1e499f3a00fdeb9b3a"),
            "region" => translate("tr_503166f739d3d3fa038de411a9c0dd4c"),
            "filter" => translate("tr_2c34bf7475ce67cfad1c45882be01ca8"),
            "contact_name" => translate("tr_cd7a9cf4fadaad9d615b893741d47b7d"),
            "contact_surname" => translate("tr_505482dce5033bb6793e4931697306e0"),
            "contact_phone" => translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"),
            "contact_email" => translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"),
            "import_item_id" => translate("tr_74d8b2c5c4627a1515588820976afde7"),
        ];
    }elseif($table == "users"){
        return [
            "name" => translate("tr_d38d6d925c80a2267031f3f03d0a9070"),
            "surname" => translate("tr_a7b7df8362d60258a7208dde0a392643"),
            "email" => translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"),
            "phone" => translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"),
            "avatar" => translate("tr_6fe66ddfb771ed8cee5252576842362a"),
            "password" => translate("tr_5ebe553e01799a927b1d045924bbd4fd"),
            "balance" => translate("tr_95dcad972e98961cdb8a49897d2fc550"),
            "organization_name" => translate("tr_16c3e7e34102c34643e18ddc60acac86"),
            "import_item_id" => translate("tr_74d8b2c5c4627a1515588820976afde7"),
        ];
    }elseif($table == "blog_posts"){
        return [
            "title" => translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"),
            "content" => translate("tr_38ca0af80cd7bd241500e81ba2e6efff"),
            "category" => translate("tr_2d7e061e5eb0c367b0539ab57305c97b"),
            "image" => translate("tr_c318d6aece415f27decf21b272d94fa2"),
            "import_item_id" => translate("tr_74d8b2c5c4627a1515588820976afde7"),
        ];
    }
}

public function getAvailableTable($table=null){
    $tables = $this->availableTables();
    return $tables[$table];
}

public function getHeaderFile($data=null){
    global $app;

    $values = [];
    $header = [];
    
    if(file_exists($app->config->storage->files_import_export.'/'.$data->filename)){

        $reader = ReaderEntityFactory::createReaderFromFile($app->config->storage->files_import_export.'/'.$data->filename);

        $extension = getInfoFile($app->config->storage->files_import_export.'/'.$data->filename)->extension;

        if($extension == "csv"){
            $reader->setFieldDelimiter(';');
        }

        $reader->open($app->config->storage->files_import_export.'/'.$data->filename);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if($rowIndex == 1){
                    $header = $row->toArray();
                }
                if($rowIndex == 2){
                    $values = $row->toArray();
                    break;
                }                    
            }
        }

        $reader->close();

        if($values){
            foreach ($values as $key => $value) {
                if(trim($value)){
                    $values[$key] = trimStr(trim($value), 64, true);
                }else{
                    $values[$key] = translate("tr_e5b328b4e1c5fd66fc9df6594dd8964c");
                }
            }
        }

    }

    return (object)["header"=>$header, "values"=>$values];

}

public function getImportsOptions($import_id=0){
    global $app;

    $data = $app->model->import_export->getAll("action=?", ["import"]);

    if($data){
        foreach ($data as $key => $value) {
            if($value["id"] == $import_id){
                echo '<option value="'.$value["id"].'" selected="" >'.$value["name"].'</option>';
            }else{
                echo '<option value="'.$value["id"].'" >'.$value["name"].'</option>';
            }
        }
    }

}

public function initExport($value=null, $page=1){
    global $app;

    $action = '';
    $output = 1000;
    $filename = $value["filename"];

    if(isset($value["filename"]) && file_exists($app->config->storage->files_import_export.'/'.$value["filename"])){

        $action = 'append';
        
        $reader = ReaderEntityFactory::createReaderFromFile($app->config->storage->files_import_export.'/'.$value["filename"]);
        $reader->setShouldFormatDates(true);
        $reader->setTempFolder($app->config->storage->files_import_export);
        $reader->open($app->config->storage->files_import_export.'/'.$value["filename"]);

        $newfilename = 'temp_'.$value["filename"];

        $writer = WriterEntityFactory::createWriterFromFile($app->config->storage->files_import_export.'/'.$newfilename);
        $writer->openToFile($app->config->storage->files_import_export.'/'.$newfilename);

        foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
            if ($sheetIndex !== 1) {
                $writer->addNewSheetAndMakeItCurrent();
            }
            foreach ($sheet->getRowIterator() as $row) {
                $writer->addRow($row);
            }
        }

    }else{

        $action = 'create';

        if($value["export_format"] == "xlsx"){
            $writer = WriterEntityFactory::createXLSXWriter();
        }else{
            $writer = WriterEntityFactory::createCSVWriter();
        }

        $writer->openToFile($app->config->storage->files_import_export.'/'.$filename);

    }

    if($value["table"] == "users"){

        $getData = $app->model->users->pagination(true)->page($page)->output($output)->sort('id desc')->getAll();

        $uploaded_count = $value["uploaded_count"] + count($getData);

        if($getData){

            unset($getData[0]["admin"]);
            unset($getData[0]["password"]);
            unset($getData[0]["role_id"]);
            unset($getData[0]["import_id"]);
            unset($getData[0]["reason_blocking_code"]);
            unset($getData[0]["time_expiration_blocking"]);
            unset($getData[0]["privileges"]);
            unset($getData[0]["tariff_id"]);
            unset($getData[0]["online_payment_status"]);
            unset($getData[0]["notifications_method"]);
            unset($getData[0]["telegram_chat_id"]);
            unset($getData[0]["uniq_hash"]);
            unset($getData[0]["notifications"]);
            unset($getData[0]["delivery_status"]);
            unset($getData[0]["import_item_id"]);

            foreach ($getData[0] as $key => $field) {
               $headerCell[] = WriterEntityFactory::createCell($key);
               $header[] = $key;
            }   

            foreach ($getData as $field) {

                $rows = [];

                $field["avatar"] = $app->storage->host(true)->name($field["avatar"])->path('user-avatar')->get();

                if($field["contacts"]){
                    $field["contacts"] = decrypt($field["contacts"]);
                }

                foreach ($header as $name_field) {
                    $rows[] = WriterEntityFactory::createCell($field[$name_field]);
                }

                $multipleRows[] = WriterEntityFactory::createRow($rows);

            }

            if($action == "create"){
                $style = (new StyleBuilder())->setFontBold()->build();
                $writer->addRow(
                    WriterEntityFactory::createRow($headerCell, $style)
                );
            }

            $writer->addRows($multipleRows); 

        }

    }elseif($value["table"] == "blog_posts"){

        $getData = $app->model->blog_posts->pagination(true)->page($page)->output($output)->sort('id desc')->getAll();

        $uploaded_count = $value["uploaded_count"] + count($getData);

        if($getData){

            foreach ($getData[0] as $key => $field) {
               $headerCell[] = WriterEntityFactory::createCell($key);
               $header[] = $key;
            }   

            foreach ($getData as $field) {

                $rows = [];

                $field["image"] = $app->storage->host(true)->name($field["image"])->path('blog')->get();

                foreach ($header as $name_field) {
                    $rows[] = WriterEntityFactory::createCell($field[$name_field]);
                }

                $multipleRows[] = WriterEntityFactory::createRow($rows);

            }

            if($action == "create"){
                $style = (new StyleBuilder())->setFontBold()->build();
                $writer->addRow(
                    WriterEntityFactory::createRow($headerCell, $style)
                );
            }

            $writer->addRows($multipleRows); 

        }

    }elseif($value["table"] == "ads"){

        $fields = ["title", "alias", "user_id", "text", "status", "article_number", "address", "address_latitude", "address_longitude", "currency_code", "price", "old_price", "media", "category_id", "city_id", "region_id", "country_id", "delivery_status ", "total_rating", "total_reviews"];

        $getData = $app->model->ads_data->pagination(true)->page($page)->output($output)->sort('id desc')->getAll("status=?", [1]);

        $uploaded_count = $value["uploaded_count"] + count($getData);

        if($getData){

            foreach ($fields as $field) {
               $headerCell[] = WriterEntityFactory::createCell($field);
               $header[] = $field;
            }   

            foreach ($getData as $field) {

                $rows = [];

                $field["status"] = $app->component->ads->status($field["status"])->name;

                if($field["contacts"]){
                    $field["contacts"] = decrypt($field["contacts"]);
                }

                foreach ($header as $name_field) {
                    $rows[] = WriterEntityFactory::createCell($field[$name_field]);
                }

                $multipleRows[] = WriterEntityFactory::createRow($rows);

            }

            if($action == "create"){
                $style = (new StyleBuilder())->setFontBold()->build();
                $writer->addRow(
                    WriterEntityFactory::createRow($headerCell, $style)
                );
            }

            $writer->addRows($multipleRows); 

        }

    }

    $writer->close();

    if($action == "append"){
        rename($app->config->storage->files_import_export.'/'.$newfilename,$app->config->storage->files_import_export.'/'.$filename);
        $reader->close();
    }

    if($app->pagination->totalPages > 1){
        if($page > $app->pagination->totalPages){
            $app->model->import_export->update(['status'=>1,'done_percent'=>100,'filename'=>$filename, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$value["errors_count"]+$errors_count], $value["id"]);
        }else{
            $page = $page + 1;
            $app->model->import_export->update(['params'=>_json_encode(['page'=>$page]),'done_percent'=>percentToCompletion($page*$output,$app->pagination->totalItems),'filename'=>$filename, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$value["errors_count"]+$errors_count], $value["id"]);
        }
    }else{
        $app->model->import_export->update(['status'=>1,'done_percent'=>100,'filename'=>$filename, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$errors_count], $value["id"]);
    }

}

public function initImport($value=null, $update=false){
    global $app;

    $errors_count = 0;

    if(isset($value["filename"]) && file_exists($app->config->storage->files_import_export.'/'.$value["filename"])){

        $reader = ReaderEntityFactory::createReaderFromFile($app->config->storage->files_import_export.'/'.$value["filename"]);

        $extension = getInfoFile($app->config->storage->files_import_export.'/'.$value["filename"])->extension;

        if($extension == "csv"){
            $reader->setFieldDelimiter(';');
        }

        $reader->open($app->config->storage->files_import_export.'/'.$value["filename"]);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if($rowIndex != 1){
                    $errors_count += $this->dataComparisonAndImport($value,$row->toArray(),$update);
                }                    
            }
        }

    }else{
        $this->addLog($value["id"], translate("tr_2b5a9e35fbbbafa4059f752520300978"));
    }

    return $errors_count;

}

public function outFeedLink($filename=null){
    global $app;

    return path($app->config->storage->files_import_export, true) .'/'.$filename;
    
}

public function status($status=0){
    global $app;
    if($status == 0){
        return (object)['name'=>translate("tr_017d8732fe062c99eb47cf54f2c7eb08"), 'label'=>'secondary'];
    }elseif($status == 1){
        return (object)['name'=>translate("tr_c665d401097529f7f09717764178123b"), 'label'=>'success'];
    }elseif($status == 2){
        return (object)['name'=>translate("tr_848a83b00a92e5664b4af49d35661a50"), 'label'=>'warning'];
    }elseif($status == 3){
        return (object)['name'=>translate("tr_c6fd3c6a629b51b28c19e8495994f4ca"), 'label'=>'danger'];
    }elseif($status == 4){
        return (object)['name'=>translate("tr_d29a4ba9bbcbf1e1ed1a6b99f8ed3c52"), 'label'=>'secondary'];
    }elseif($status == 5){
        return (object)['name'=>translate("tr_be68dffdb4af0ae31056c5b4dc513cab"), 'label'=>'warning'];
    }
}

public function uploadImages($images=null, $path=null, $count=1){
    global $app;

    $result = [];
    $images = explode(",", $images);

    if($images){
        foreach (array_slice($images, 0, $count) as $key => $value) {
            if($value){
                $filename = md5(time().uniqid()) . '.webp';
                $data = _file_get_contents($value);
                if($data){
                    if(_file_put_contents($path.'/'.$filename, $data)){
                        $size = filesize($path.'/'.$filename);
                        if($size > $app->settings->import_upload_min_size_image){
                            $result[] = clearPath($path.'/'.$filename);
                        }else{
                            unlink($path.'/'.$filename);
                        }
                    }
                }
            }
        }
    }

    return $result;

}

public function uploadImagesAds($images=null, $count=1){
    global $app;

    $result = [];
    $inline = [];

    $folder = md5($app->datetime->format("Y-m-d")->getDate());

    $images = explode(",", $images);

    if($images){

        createFolder($app->config->storage->market->images.'/'.$folder);

        foreach (array_slice($images, 0, $count) as $key => $value) {
            if($value){
                $filename = md5(time().uniqid());
                $data = _file_get_contents($value);
                if($data){
                    if(_file_put_contents($app->config->storage->market->images.'/'.$folder.'/'.$filename.'.webp', $data)){
                        $size = filesize($app->config->storage->market->images.'/'.$folder.'/'.$filename.'.webp');
                        if($size > $app->settings->import_upload_min_size_image){
                            $inline[] = ["type"=>"image", "name"=>$filename];
                        }else{
                            unlink($app->config->storage->market->images.'/'.$folder.'/'.$filename.'.webp');
                        }
                    }
                }
            }
        }

        if($inline){

            foreach ($inline as $key => $value) {

               $result["images"][] = ["name"=>$value["name"].'.webp', "folder"=>$folder]; 
               $result["inline"][$value["name"]] = ["type"=>"image", "name"=>$value["name"].'.webp', "folder"=>$folder]; 

            }

        }

    }

    return $result ? _json_encode($result) : [];

}

public function uploadedCount($import_id=0, $table=null){
    global $app;

    if($table == "ads"){
        return $app->model->ads_data->count("import_id=?", [$import_id]);
    }elseif($table == "users"){
        return $app->model->users->count("import_id=?", [$import_id]);
    }elseif($table == "blog_posts"){
        return $app->model->blog_posts->count("import_id=?", [$import_id]);
    }

    return 0;

}



}