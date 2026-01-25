<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class MapController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function loadDeliveryPointItem()
{   

    ob_start();

    $content = '';
    $params = _json_decode(urldecode($_POST["params"]));

    if(!$_POST['id']){
        return json_answer(["content"=>""]);
    }

    $data = $this->model->delivery_points->find("id=?", [$_POST['id']]);

    if($data){

        $delivery = $this->model->system_delivery_services->find("id=?", [$data->delivery_id]);

        if(!$params['send']){
            $calculationData = $this->component->delivery->calculationData($data->id, $params['item_id'], $this->user->data->id);
        }

        ?>
        <div class="btn-custom-mini button-color-scheme2 actionCloseSidebarMapDelivery" ><?php echo translate("tr_dd9463bd5d0c650b468fc5d6cfa1073c"); ?></div>
        <div class="mt20">
          <img src="<?php echo $this->addons->delivery($delivery->alias)->logo(); ?>" height="30" style="margin-right: 5px;" >
          <?php echo $delivery->name; ?>
        </div>
        <div class="mt10" >
            <h5><?php echo $data->address; ?></h5>

            <?php if($calculationData["status"] == true){ ?>
            <p class="font-bold" ><?php echo translate("tr_b973ee86903271172c9b4f5529bc19bb"); ?> <?php echo $calculationData["amount"]; ?>, <?php echo $calculationData["days"]; ?></p>
            <?php } ?>

            <p><?php echo $data->workshedule; ?></p>
            <p><?php echo $data->text; ?></p>

            <?php

            if(!$params['send']){

                if($delivery->required_price_order){
                    if($calculationData["status"] == true){
                        ?>
                        <div class="btn-custom-mini button-color-scheme3 actionChangePointMapDelivery" data-point="<?php echo $delivery->name; ?>, <?php echo $data->address; ?>" data-delivery-amount="<?php echo $calculationData["amount_formatted"]; ?>" data-delivery-days="<?php echo $calculationData["days"]; ?>" data-id="<?php echo $data->id; ?>" data-point-code="<?php echo $data->code; ?>" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
                        <?php
                    }else{
                        ?>
                        <div class="mt10 font-bold" ><?php echo translate("tr_7c8a6b672aec9e67d4591cc551a3beab"); ?></div>
                        <?php                    
                    }
                }else{
                    ?>
                    <div class="btn-custom-mini button-color-scheme3 actionChangePointMapDelivery" data-point="<?php echo $delivery->name; ?>, <?php echo $data->address; ?>" data-id="<?php echo $data->id; ?>" data-point-code="<?php echo $data->code; ?>" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
                    <?php
                }

            }else{

                ?>
                <div class="btn-custom-mini button-color-scheme3 actionChangePointMapDelivery" data-point="<?php echo $delivery->name; ?>, <?php echo $data->address; ?>" data-id="<?php echo $data->id; ?>" data-point-code="<?php echo $data->code; ?>" ><?php echo translate("tr_2b02caddb199f024c4a10c37660db0a1"); ?></div>
                <?php

            }

            ?>

        </div>
        <?php

    }

    $content = ob_get_contents();
    ob_end_clean();

    return json_answer(["content"=>$content]);

}

public function loadDeliveryPointsMarkers()
{   

    $data = [];
    $ids = [];
    $result = [];

    $params = _json_decode(urldecode($_POST["params"]));

    if(intval($_POST["id"])){

        $delivery = $this->model->system_delivery_services->find("id=? and status=?", [intval($_POST["id"]), 1]);

        if($delivery){

            if(intval($params["send"])){
                $data = $this->model->delivery_points->getAll("delivery_id=? and send=? and ((latitude < ? and longitude < ?) and (latitude > ? and longitude > ?))", [intval($_POST["id"]),1,$_POST["topLeft"]?:null,$_POST["topRight"]?:null,$_POST["bottomLeft"]?:null,$_POST["bottomRight"]?:null]);
            }else{
                $data = $this->model->delivery_points->getAll("delivery_id=? and ((latitude < ? and longitude < ?) and (latitude > ? and longitude > ?))", [intval($_POST["id"]),$_POST["topLeft"]?:null,$_POST["topRight"]?:null,$_POST["bottomLeft"]?:null,$_POST["bottomRight"]?:null]);
            }

        }

        if($data){

            $result = $this->component->geo->mapBuildMarkersByDelivery($data);

        }

    }

    return json_answer($result);

}

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

public function loadItems()
{   

    $content = '';
    $data = [];
    $ids = [];

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;

    $this->pagination->request($_POST);

    $build = $this->component->catalog->buildQuery($_POST, intval($_POST["c_id"]), $this->session->get("geo"));

    if($build){

        if(isset($_POST['ids'])){

            $build["query"] = $build["query"] . " and id IN(".$_POST['ids'].")"; 

        }else{

            $build["query"] = $build["query"] . " and " . "(((address_latitude < ? and address_longitude < ?) and (address_latitude > ? and address_longitude > ?)) or ((geo_latitude < ? and geo_longitude < ?) and (geo_latitude > ? and geo_longitude > ?)))";
            $build["params"][] = $_POST["topLeft"];     
            $build["params"][] = $_POST["topRight"];
            $build["params"][] = $_POST["bottomLeft"];
            $build["params"][] = $_POST["bottomRight"];
            $build["params"][] = $_POST["topLeft"];     
            $build["params"][] = $_POST["topRight"];
            $build["params"][] = $_POST["bottomLeft"];
            $build["params"][] = $_POST["bottomRight"];

        }

        $data = $this->model->ads_data->pagination(true)->page($page)->output($this->settings->out_default_count_items)->getAll($build["query"], $build["params"]);
    }

    if($data){

        if($page <= $this->pagination->pages()){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $ids[] = $value->id;

                $content .= $this->view->setParamsComponent(['value'=>$value])->includeComponent('items/map-list.tpl');

            }

            $this->component->catalog->updateCountDisplay($ids);

        }

        if($page + 1 <= $this->pagination->pages()){

            $result = '

               <div class="row" style="display: none;" >

                  '.$content.'

               </div>

               <div class="text-center" >
                  <button class="btn-custom button-color-scheme2 actionMapShowMoreItems" >'.translate("tr_11d9e7ea0320006d822a967777abd16a").'</button>
               </div>

            ';

        }else{

            $result = '

               <div class="row" style="display: none;" >

                  '.$content.'

               </div>

            ';

        }

    }else{

        $result = '

           <div class="search-map-sidebar-not-found" >

              <h5><strong>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</strong></h5>
              <p>'.translate("tr_a15496329a0f91147ee1d56fde0854f7").'</p>

           </div>

        ';            

    }

    return json_answer(["content"=>$result]);

}

public function loadMarkers()
{   

    $content = '';
    $data = [];
    $ids = [];
    $result = [];

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;

    $this->pagination->request($_POST);

    $build = $this->component->catalog->buildQuery($_POST, intval($_POST["c_id"]), $this->session->get("geo"));

    if($build){
        $build["query"] = $build["query"] . " and " . "(((address_latitude < ? and address_longitude < ?) and (address_latitude > ? and address_longitude > ?)) or ((geo_latitude < ? and geo_longitude < ?) and (geo_latitude > ? and geo_longitude > ?)))";
        $build["params"][] = $_POST["topLeft"];     
        $build["params"][] = $_POST["topRight"];
        $build["params"][] = $_POST["bottomLeft"];
        $build["params"][] = $_POST["bottomRight"];       
        $build["params"][] = $_POST["topLeft"];     
        $build["params"][] = $_POST["topRight"];
        $build["params"][] = $_POST["bottomLeft"];
        $build["params"][] = $_POST["bottomRight"];

        $data = $this->model->ads_data->getAll($build["query"], $build["params"]);
    }

    if($data){

        $result = $this->component->geo->mapBuildMarkersByAds($data);

    }

    return json_answer($result);

}

public function main($request=null)
{   

    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_card.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/map.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/catalog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if($request){

        if($this->settings->active_countries){

            $request_array = explode("/", trim($request, "/"));

            if($this->component->geo->statusMultiCountries()){

                if(count($request_array) == 1){

                    $data->country = $this->model->geo_countries->find("alias=? and status=?", [$request_array[0],1]);
                    if(!$data->country){
                        abort(404);
                    }

                }elseif(count($request_array) == 2){
                    
                    $data->country = $this->model->geo_countries->find("alias=? and status=?", [$request_array[0],1]);
                    if(!$data->country){
                        abort(404);
                    }

                    $data->region = $this->model->geo_regions->find("alias=? and status=? and country_id=?", [$request_array[1],1,$data->country->id]);

                    if(!$data->region){
                        $data->city = $this->model->geo_cities->find("alias=? and status=? and country_id=?", [$request_array[1],1,$data->country->id]);
                        if(!$data->city){
                            abort(404);
                        }
                    }

                }elseif(count($request_array) == 3){
                    
                    $data->country = $this->model->geo_countries->find("alias=? and status=?", [$request_array[0],1]);
                    if(!$data->country){
                        abort(404);
                    }

                    $data->region = $this->model->geo_regions->find("alias=? and status=? and country_id=?", [$request_array[1],1,$data->country->id]);

                    if(!$data->region){
                        abort(404);
                    }

                    $data->city = $this->model->geo_cities->find("alias=? and status=? and region_id=? and country_id=?", [$request_array[2],1,$data->region->id,$data->country->id]);

                    if(!$data->city){
                        abort(404);
                    }

                }

            }else{

                if($request != "all"){

                    if(count($request_array) == 1){

                        $data->region = $this->model->geo_regions->find("alias=? and status=?", [$request_array[0],1]);

                        if(!$data->region){
                            $data->city = $this->model->geo_cities->find("alias=? and status=?", [$request_array[0],1]);
                            if(!$data->city){
                                abort(404);
                            }
                        }

                    }elseif(count($request_array) == 2){
                        
                        $data->region = $this->model->geo_regions->find("alias=? and status=?", [$request_array[0],1]);

                        if(!$data->region){
                            abort(404);
                        }

                        $data->city = $this->model->geo_cities->find("alias=? and region_id=? and status=?", [$request_array[1],$data->region->id,1]);

                        if(!$data->city){
                            abort(404);
                        }

                    }

                }

            }

        }           

        if($data->city){
            $this->component->geo->setChange($data->city->id, "city");
        }elseif($data->region){
            $this->component->geo->setChange($data->region->id, "region");
        }elseif($data->country){
            $this->component->geo->setChange($data->country->id, "country");
        }else{
            $this->session->delete("geo");
        }

    }        

    $seo = $this->component->seo->content();

    return $this->view->render('map', ["data"=>(object)$data, "seo"=>$seo]);

}



 }