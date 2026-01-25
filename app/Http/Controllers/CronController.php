<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class CronController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function ads(){

    $ids = [];
    $data = [];
    $auto_renewal_data = [];
    $auto_renewal_ids = [];

    $expiration = $this->component->ads->calculationTimeExpiration();

    $getCompletedAds = $this->model->ads_data->sort("id asc limit 500")->getAll("now() >= time_expiration and status=?", [1]);
    
    if($getCompletedAds){

        foreach ($getCompletedAds as $value) {
            if($value["auto_renewal_status"]){
                $auto_renewal_data[] = $value;
                $auto_renewal_ids[] = $value["id"];
            }else{
                $data[] = $value;
                $ids[] = $value["id"];
            }
        }

        if($ids){
            $this->model->ads_data->update(["status"=>2], ["id IN(".implode(",", $ids).") and auto_renewal_status=?", [0]]);
        }

        if($auto_renewal_ids){
            $this->model->ads_data->update(["status"=>1, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days, "time_sorting"=>$this->datetime->getDate()], ["id IN(".implode(",", $auto_renewal_ids).") and auto_renewal_status=?", [1]]);
        }

        if($data){
            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $this->notify->params(["ad_title"=>$value->title, "ad_id"=>$value->id, "ad_link"=>$this->component->ads->buildAliasesAdCard($value)])->userId($value->user_id)->code("board_ad_end_term")->addWaiting();

            }
        }

    }

}

public function buildFeeds()
{   

    $getFeeds = $this->model->import_export_feeds->getAll("autoupdate=?", [1]);

    if($getFeeds){

        foreach ($getFeeds as $value) {

            $this->component->import_export->buildFeed($value["id"]);

        }

    }

}

public function chat(){

    $responders = $this->model->chat_responders->sort("id asc")->getAll("status=?", [0]);

    if($responders){

        $users = $this->model->users->getAll("status=?", [1]);

        foreach ($responders as $key => $value) {

            if(!$value["time_send"] || $this->datetime->currentTime() >= strtotime($value["time_send"])){

                $this->model->chat_responders->update(["status"=>1], $value["id"]);

                foreach (_json_decode($value["channels"]) as $channel_id) {
                    
                    $getChannel = $this->model->chat_channels->find("id=?", [$channel_id]);

                    if($getChannel){

                        if($getChannel->type == "support"){

                            if($users){
                                foreach ($users as $user) { 
                                    
                                    $this->component->chat->sendMessage(["from_user_id"=>0,"whom_user_id"=>$user["id"], "channel_id"=>$channel_id, "text"=>$value["text"], "attach_files"=>$value["image"] ? [$value["image"]] : null, "responder_id"=>$value["id"]]);
                                    $this->notify->sendMessageFirebase(["token"=>$user["firebase_token"], "title"=>$getChannel->name, "text"=>$value["text"], "screen"=>"dialogue", "channel_id"=>$channel_id]);

                                }
                            }

                        }elseif($getChannel->type == "closed"){

                            $this->component->chat->sendMessage(["from_user_id"=>0, "channel_id"=>$channel_id, "text"=>$value["text"], "attach_files"=>$value["image"] ? [$value["image"]] : null, "responder_id"=>$value["id"]]);

                            if($users){
                                foreach ($users as $user) { 
                                    
                                    if(!$this->component->chat->checkChannelDisableNotify($channel_id, $user["id"])){
                                        $this->notify->sendMessageFirebase(["token"=>$user["firebase_token"], "title"=>$getChannel->name, "text"=>$value["text"], "screen"=>"dialogue", "channel_id"=>$channel_id]);
                                    }

                                }
                            }

                        }else{

                            $this->component->chat->sendMessage(["from_user_id"=>0, "channel_id"=>$channel_id, "text"=>$value["text"], "attach_files"=>$value["image"] ? [$value["image"]] : null, "responder_id"=>$value["id"]]);

                        }

                    }

                }

            }

        }
    }
    

}

public function chatNotifications(){

    $users_list = [];

    $total = $this->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=? and notification_status=?", [0,0,0,0,1,0]);

    if($total){

        $text = translate("tr_2ce93b17414903790430a4ee3b19565d") . " " . $total . " " . endingWord($total, translate("tr_846ff7b29e169d829b8aa500fff5eb73"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"));

        $notifications = $this->model->users_notify_list->getAll("action_code=?", ["system_chat_new_message"]);

        if($notifications){
            foreach ($notifications as $item) {

                $this->notify->params(["count"=>$total, "text"=>$text])->userId($item["user_id"])->code("system_chat_new_message")->sendByUser();

            }
        }

    }

    $getUsers = $this->model->users->getAll("status=? and admin=?",[1,0]);

    if($getUsers){
        foreach ($getUsers as $key => $value) {

            $total = $this->component->chat->updateCountMessages($value["id"], true);
            if($total["count"]){
                $text = translate("tr_2ce93b17414903790430a4ee3b19565d") . " " . $total["count"] . " " . endingWord($total["count"], translate("tr_846ff7b29e169d829b8aa500fff5eb73"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"), translate("tr_f94bbcd6ef85e15581e7f132472a31a4"));
                $this->notify->params(["count"=>$total["count"], "text"=>$text])->userId($value["id"])->code("chat_new_message")->sendByUser();
                $this->notify->sendMessageFirebase(["token"=>$value["firebase_token"], "title"=>$this->settings->api_app_project_name, "text"=>$text]);
            }

        }
    }

    $this->model->chat_messages->updateQuery("notification_status=?", [1]);

}

public function clearTempFiles(){

    $dirTemp = $this->config->storage->temp;

    $files = scandir($dirTemp);

    unset($files[0]);
    unset($files[1]);

    if(!$files) return;

    foreach ($files as $fileName) {
        
        if($fileName != ".htaccess" && $fileName != "ffmpeg" && $fileName != "mpdf"){
            $unix_time = filemtime($dirTemp . "/" . $fileName) + 10800;
            if($unix_time < time()){
                unlink($dirTemp . "/" . $fileName);
            }
        }

    }    

}

public function clearVerifyCodes(){

    $this->model->users_waiting_verify_code->delete("unix_timestamp(now()) > unix_timestamp(time_create) + 300");

}

public function deals(){

    $getDeals = $this->model->transactions_deals->getAll("unix_timestamp(time_create) + 86400 <= unix_timestamp(now()) and (status_processing=? or status_processing=?) and status_completed=?", ["awaiting_confirmation","confirmed_order",0]);

    if($getDeals){
        foreach ($getDeals as $value) {

            if($value["status_processing"] == "awaiting_confirmation"){
                $this->component->transaction->cancelDeal($value["order_id"], $value["whom_user_id"]);
            }elseif($value["status_processing"] == "confirmed_order"){
                if(!$value["status_payment"]){
                    $this->component->transaction->cancelDeal($value["order_id"], $value["whom_user_id"]);
                }
            }
            
        }
    }


    $getDeals = $this->model->transactions_deals->getAll("DATE_ADD(`time_create`, INTERVAL ".$this->settings->secure_deal_auto_closing_time." DAY) <= now() and status_payment=? and status_completed=?", [1,0]);
    
    if($getDeals){
        foreach ($getDeals as $value) {

            if($value["status_processing"] == "access_open" || $value["status_processing"] == "confirmed_transfer" || $value["status_processing"] == "confirmed_completion_service"){
                $this->component->transaction->changeStatusDeal($value["order_id"], $value["from_user_id"], "completed_order");
            }
            
        }
    }

    $getBookingOrders = $this->model->transactions_deals->getAll("now() >= time_completed and status_payment=? and status_completed=? and status_processing=?", [1,0,"booked"]);
    
    if($getBookingOrders){
        foreach ($getBookingOrders as $value) {

            $this->component->transaction->changeStatusDeal($value["order_id"], $value["from_user_id"], "completed_order");
            
        }
    }

    $service = $this->component->transaction->getServiceSecureDeal();

    if($service){
        if ($service->secure_deal_status) {
            
            $getPayments = $this->model->transactions_deals_payments->sort("id asc limit 100")->getAll("status_processing=?", ["awaiting_payment"]);
            if($getPayments){
                foreach ($getPayments as $key => $value) {
                    
                    $this->component->transaction->createPayout($value, $service->alias);

                }
            }

        }
    }

}

public function deliveryHistory(){

    $data = $this->model->transactions_deals->getAll("status_processing=? and delivery_service_id!=?", ["confirmed_order", 0]);
    if($data){

        foreach ($data as $key => $value) {
            $this->component->delivery->updateHistoryData($value);
        }

    }

}

public function execution($key=null)
{   

    if($this->config->app->private_service_key != $key){
        return false;
    }

    $getTasks = $this->model->system_cron_tasks->getAll();

    if($getTasks){
        foreach ($getTasks as $key => $value) {
            
            try {

                if($value["time_current"] >= $value["time_execution"]){

                    $this->model->system_cron_tasks->update(['time_current'=>1], $value["id"]);  
                    $this->{$value["class_name"]}();
                  
                }else{
                    $this->model->system_cron_tasks->update(['time_current'=>(int)$value["time_current"]+1], $value["id"]);
                }

            } catch (Exception $e) {
                Logger::set("Cron ".$value["class_name"]." error: {$e->getMessage()}");
            }

        }
    }

    $this->model->settings->update($this->datetime->getDate(),'crontab_time_last_execution');

}

public function importExport()
{   

    $getTasks = $this->model->import_export->getAll("status=? order by id desc limit ?", [2,1]);

    if($getTasks){

        foreach ($getTasks as $value) {

            $paramsData = isset($value["params"]) ? _json_decode($value["params"]) : [];
            $page = $paramsData['page'] ? (int)$paramsData['page'] : 0;
            $uploaded_count = 0;
            $errors_count = 0;
            
            if($value["action"] == "import"){

                $errors_count = $this->component->import_export->initImport($value);

                $uploaded_count = $this->component->import_export->uploadedCount($value["id"], $value["table"]);

                if($value["autoupdate"]){
                    $status = 4;
                }else{
                    $status = 1;
                }

                $this->model->import_export->update(['status'=>$status,'done_percent'=>100, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$errors_count], $value["id"]);

            }elseif($value["action"] == "export"){

                $this->component->import_export->initExport($value, $page);

            }

        }

    }

}

public function loadCitiesByUniApi(){

    $getImportCountry = $this->model->geo_countries->sort('id asc')->find("status_api_import=?", [1]);

    if($getImportCountry){

        $cities = $this->system->uniApi("cities_load", ["country_id"=>$getImportCountry->temp_id, "page"=>$getImportCountry->page_api_import]);

        if($cities){
            foreach ($cities as $key => $value) {

                if($value["region_id"]){
                    $getRegion = $this->model->geo_regions->find("temp_id=?", [$value["region_id"]]);
                    if($getRegion){
                        $value["region_id"] = $getRegion->id;
                    }
                }

                $value["country_id"] = $getImportCountry->id;

                unset($value["id"]);

                $this->model->geo_cities->insert($value);

            }
            $this->model->geo_countries->update(["page_api_import"=>$getImportCountry->page_api_import+1], $getImportCountry->id);
        }else{
            $this->model->geo_countries->update(["status_api_import"=>2], $getImportCountry->id);
        }

    }

}

public function notifications(){

    $getNotifications = $this->model->users_waiting_notifications->getAll();
    if($getNotifications){
        foreach ($getNotifications as $key => $value) {

            $params = _json_decode($value["params"]);

            if($value["user_id"]){

                $this->notify->params($params)->userId($value["user_id"])->code($value["action_code"])->sendByUser();

            }else{

                $notifications = $this->model->users_notify_list->getAll("action_code=?", [$value["action_code"]]);

                if($notifications){
                    foreach ($notifications as $item) {

                        $this->notify->params($params)->userId($item["user_id"])->code($value["action_code"])->sendByUser();

                    }
                }                        

            }

            $this->model->users_waiting_notifications->delete("id=?", [$value["id"]]);

        }
    }

}

public function runUpdateImportExport()
{   

    $getTasks = $this->model->import_export->getAll("status=? and now() > next_update order by id desc limit ?", [4,1]);

    if($getTasks){

        foreach ($getTasks as $value) {

            $this->model->import_export->update(['status'=>5], $value["id"]);

            $paramsData = isset($value["params"]) ? _json_decode($value["params"]) : [];
            $uploaded_count = 0;
            $errors_count = 0;
            
            if($value["action"] == "import"){

                unlink($this->config->storage->files_import_export . '/' . $value["filename"]);

                $data = _file_get_contents($value['link_file']);

                _file_put_contents($this->config->storage->files_import_export . '/' . $value["filename"], $data);

                $errors_count = $this->component->import_export->initImport($value, true);

                $uploaded_count = $this->component->import_export->uploadedCount($value["id"], $value["table"]);

            }

            $this->model->import_export->update(['status'=>4, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$value["errors_count"]+$errors_count, 'next_update'=>$this->datetime->addSeconds($value["update_interval"])->getDate()], $value["id"]);

        }

    }

}

public function serviceTop(){

    if($this->settings->out_default_count_items){
        $this->model->ads_data->updateQuery("time_sorting=? where service_top_status=? order by count_display asc limit ?", [$this->datetime->getDate(),1,$this->settings->out_default_count_items]);
    }

}

public function services(){

    $ids = [];

    $getOrders = $this->model->ads_services_orders->sort("id asc limit 500")->getAll("now() >= time_expiration");
    
    if($getOrders){

        foreach ($getOrders as $key => $value) {
            $ids[] = $value["id"];
            $this->component->ad_paid_services->deactivation($value["service_id"],$value["ad_id"]);
        }

        $this->model->ads_services_orders->delete("id IN(".implode(",", $ids).")");

    }

}

public function shops(){

    $shops_ids = [];

    $getShops = $this->model->shops->getAll("status=?", ["published"]);

    if($getShops){

        foreach ($getShops as $value) {
            $order = $this->model->users_tariffs_orders->find("status=? and user_id=?", [1, $value["user_id"]]);
            if(!$order){
                $shops_ids[] = $value["id"];
            }elseif($order->time_expiration != null && time() > strtotime($order->time_expiration)){
                $shops_ids[] = $value["id"];
            }
        }

        if($shops_ids){
            $this->model->shops->update(["status"=>"blocked"], ["id IN(".implode(",", $shops_ids).")", []]);
        }

    }

}

public function sitemap(){

     $content = "";
     $lines = "";

     if(compareValues($this->settings->seo_sitemap_output, "cities") || compareValues($this->settings->seo_sitemap_output, "ads_categories") || compareValues($this->settings->seo_sitemap_output, "ads")){

        $ads = $this->model->ads_data->sort("id desc limit 10000")->getAll("status=?", [1]);

        if($ads){

            foreach ($ads as $value) {

                if(compareValues($this->settings->seo_sitemap_output, "cities")){

                    $city = $this->model->geo_cities->cacheKey(["id"=>$value["city_id"]])->find("id=?", [$value["city_id"]]);

                    if($city){
                        $lines .= '
                            <url>
                                <loc>'.outLink($city->alias).'</loc>
                                <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                                <priority>0.8</priority>
                            </url>
                        ';
                    }

                }

                if(compareValues($this->settings->seo_sitemap_output, "ads_categories")){

                    $lines .= '
                        <url>
                            <loc>'.$this->component->ads_categories->buildAliases(["id"=>$value["category_id"]]).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';

                }

                if(compareValues($this->settings->seo_sitemap_output, "ads")){

                    $value = $this->component->ads->getDataByValue($value);

                    $lines .= '
                        <url>
                            <loc>'.$this->component->ads->buildAliasesAdCard($value).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';

                }

            }

        }

     }

     if(compareValues($this->settings->seo_sitemap_output, "link_filters")){
        
        $filtersLinks = $this->model->ads_filters_links->sort("id desc")->getAll();

        if($filtersLinks){

            foreach ($filtersLinks as $value) {

                $lines .= '
                    <url>
                        <loc>'.$this->component->ads_filters->buildAliasesLink($value).'</loc>
                        <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                        <priority>0.8</priority>
                    </url>
                ';

            }

        }

     }

     if(compareValues($this->settings->seo_sitemap_output, "blog_posts") || compareValues($this->settings->seo_sitemap_output, "blog_categories")){
        
        $posts = $this->model->blog_posts->sort("id desc")->getAll("status=?", [1]);

        if($posts){

            foreach ($posts as $value) {

                if(compareValues($this->settings->seo_sitemap_output, "blog_posts")){

                    $lines .= '
                        <url>
                            <loc>'.$this->component->blog->buildAliasesPostCard($value).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';

                }

                if(compareValues($this->settings->seo_sitemap_output, "blog_categories")){

                    $lines .= '
                        <url>
                            <loc>'.$this->component->blog_categories->buildAliases(["id"=>$value["category_id"]]).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';                        

                }

            }

        }                

     }

     if(compareValues($this->settings->seo_sitemap_output, "pages")){
        
        $pages = $this->model->template_pages->getAll("freeze=? and alias is not null", [0]);

        if($pages){

            foreach ($pages as $value) {

                $lines .= '
                    <url>
                        <loc>'.outLink($value["alias"]).'</loc>
                        <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                        <priority>0.8</priority>
                    </url>
                ';

            }

        }

     }

     if(compareValues($this->settings->seo_sitemap_output, "shops")){
        
        $shops = $this->model->shops->getAll("status=?", [1]);

        if($shops){

            foreach ($shops as $value) {

                $lines .= '
                    <url>
                        <loc>'.$this->component->shop->linkToShopCard($value["alias"]).'</loc>
                        <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                        <priority>0.8</priority>
                    </url>
                ';

            }

        }

     }

     $content = '
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
            '.$lines.'
        </urlset>
     ';

     _file_put_contents(BASE_PATH . "/sitemap.xml", $content);

}

public function stories(){

    $getStories = $this->model->stories_media->sort("id desc limit 100")->getAll("now() >= time_expiration and status=?", [1]);
    
    if($getStories){

        foreach ($getStories as $key => $value) {
            $this->component->stories->delete($value["id"]);
        }

    }        

}

public function storiesMakeCollage(){

    $data = $this->model->stories_waiting_make_collage->getAll();

    if($data){
        foreach ($data as $key => $value) {
            $this->model->stories_waiting_make_collage->delete("id=?", [$value["id"]]);
            $this->component->stories->makeCollageItemAndPublication($value["item_id"], $value["count_day"]);
        }
    }  

}

public function systemReports(){

    if($this->settings->system_report_status){

        if(!$this->settings->system_report_last_time_generation){
            $this->model->settings->update($this->datetime->getDate(),'system_report_last_time_generation');
        }

        if($this->settings->system_report_period == 24){
            $date = $this->datetime->format("Y-m-d")->addDay(1)->getDate($this->settings->system_report_last_time_generation) . ' ' . $this->settings->system_report_send_time;
        }else{
            $date = $this->datetime->addHours($this->settings->system_report_period)->getDate($this->settings->system_report_last_time_generation);
        }

        if($this->datetime->getDate() >= $date){

            $data = $this->system->statisticReportByHours();

            if(!$this->settings->system_report_send_if_zero){

                if(!$this->system->statisticReportHasData($data)){
                    $this->model->settings->update($this->datetime->getDate(),'system_report_last_time_generation');
                    return;
                }

            }

            $this->model->traffic_report->truncate();
            $this->model->settings->update($this->datetime->getDate(),'system_report_last_time_generation');

            $this->notify->sendReport($data);

        }

    }      

}

public function tariff(){

    $ids = [];
    $user_ids = [];

    $getOrders = $this->model->users_tariffs_orders->sort("id asc limit 500")->getAll("time_expiration is not null and now() >= time_expiration and status=?", [1]);

    if($getOrders){

        foreach ($getOrders as $value) {
            $ids[] = $value["id"];
            $user_ids[] = $value["user_id"];
            $this->notify->params([])->userId($value["user_id"])->code("service_tariff_end_term")->addWaiting();
        }

        $this->model->users_tariffs_orders->update(["status"=>0], ["id IN(".implode(",", $ids).")", []]);

        $this->model->shops->update(["status"=>"blocked"], ["user_id IN(".implode(",", $user_ids).")", []]);

    }

}

public function tariffNotifications(){

    $getOrders = $this->model->users_tariffs_orders->sort("id asc limit 500")->getAll("now() < time_expiration and unix_timestamp(now()) + 3600 >= unix_timestamp(time_expiration) and status=?", [1]);

    if($getOrders){

        foreach ($getOrders as $value) {
            $this->notify->params([])->userId($value["user_id"])->code("soon_service_tariff_end_term")->addWaiting();
        }

    }

}

public function uniApi(){

    $result = $this->system->uniApi("check-auth");
    if($result){
        if($result["status"]){
            $this->model->settings->update(_json_encode($result["data"]),"uniid_data");
        }else{
            $this->model->settings->update("","uniid_token");
            $this->model->settings->update("","uniid_data");
        }
    }else{
        $this->model->settings->update("","uniid_token");
        $this->model->settings->update("","uniid_data");
    }


    $apiNotifications = $this->system->uniApi("notifications");

    $this->model->settings->update(_json_encode($apiNotifications),"uni_api_last_notifications");

}

public function updateAdsStat(){

    $data = $this->model->ads_stat->getAll();     

    if($data){

        foreach ($data as $key => $value) {

            $parentIds = $this->component->ads_categories->joinId($value["category_id"])->getParentIds($value["category_id"]); 

            $count = $this->model->ads_data->count("category_id IN(".$parentIds.") and city_id=? and region_id=? and country_id=? and status=?", [$value["city_id"],$value["region_id"],$value["country_id"],1]);

            if($count){
                $this->model->ads_stat->update(["count_items"=>$count], $value["id"]); 
            }else{
                $this->model->ads_stat->delete("id=?", [$value["id"]]); 
            }

        }

    } 

}

public function users(){

    $this->model->traffic_realtime->delete("unix_timestamp(now()) > unix_timestamp(time_update) + 600");

    $getUsers = $this->model->users->sort("id asc limit 500")->getAll("time_expiration_blocking is not null and now() >= time_expiration_blocking and status=?", [2]);
    
    if($getUsers){
        foreach ($getUsers as $value) {

            $this->model->users->update(["time_expiration_blocking"=>null, "status"=>1], $value["id"]);
            
        }
    }

}



 }