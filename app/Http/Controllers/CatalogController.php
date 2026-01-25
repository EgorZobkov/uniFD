<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class CatalogController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function catalog($main_request=null)
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/catalog.js\" type=\"module\" ></script>"]);

    $data = $this->component->catalog->requestData($main_request);

    if(!$_GET['search']){
        if($data->category){
           if($data->category->personal_page_status && $data->category->personal_page_id){

              $page = $this->model->template_pages->find("id=?", [$data->category->personal_page_id]);

              if($page){

                $seo = $this->component->seo->content($data,$data->category->personal_page_id);

                return $this->view->render($page->template_name, ["data"=>(object)$data, "seo"=>(object)$seo]);

              }

           }
        }
        $seo = $this->component->seo->content($data);
    }else{
        $this->component->search->fixingRequest($_GET["search"], getFullURI(), $this->user->data->id);
        $geo = $this->session->get("geo");
        if($geo){
            $seo["meta_title"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."» ".$geo->declension;
            $seo["h1"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."» ".$geo->declension;
        }else{
            $seo["meta_title"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
            $seo["h1"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
        }
    }

    return $this->view->render('catalog', ["data"=>(object)$data, "seo"=>(object)$seo]);
}

public function changeViewItem()
{   

    if($_POST['view'] == "grid"){
        $this->session->set("item-view", "grid");
    }else{
        $this->session->set("item-view", "list");
    }

    return json_answer(["status"=>true]);

}

public function clearFilters(){

    $params = [];
    $url = trim(urldecode($_POST['url']), "/");

    if($url){

        $query = explode("?", $url);

        if($query[1]){
            parse_str($query[1], $params);
            if($params["filter"]) unset($params["filter"]);       
        }

        $url = parse_url(getHost(true, false).'/'.$url, PHP_URL_PATH);

        $last = end(explode("/", $url));

        $filter_link = $this->model->ads_filters_links->find('alias=?', [$last]);
        if($filter_link){

            $category = $this->component->ads_categories->checkCategoriesByIdCatalog($filter_link->category_id);

            if($params){
                return json_answer(["link"=>$this->component->ads_categories->buildAliases((array)$category).'?'.http_build_query($params)]);   
            }else{
                return json_answer(["link"=>$this->component->ads_categories->buildAliases((array)$category)]);
            }

        }else{

            if($params){ 
                return json_answer(["link"=>getHost(true, false).'/'.$query[0].'?'.http_build_query($params)]);  
            }else{
                return json_answer(["link"=>getHost(true, false).'/'.$query[0]]);
            }

        }

    }

    return json_answer(["link"=>$url]);

}

public function loadFilterItems(){

    $filters = parse_url($_POST['filters']);

    return json_answer(["content"=>$this->component->ads_filters->getFiltersParentByCatalog($filters["query"], $_POST["filter_id"],$_POST["item_id"])]);

}

public function loadItems()
{   

    $content = '';
    $data = [];
    $ids = [];

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;

    $this->pagination->request($_POST);

    if($_POST["sort"] == "news"){
        $sort = 'id desc';
    }elseif($_POST["sort"] == "price_asc"){
        $sort = 'price asc';
    }elseif($_POST["sort"] == "price_desc"){
        $sort = 'price desc';
    }else{
        $sort = 'time_sorting desc';
    }

    $category_id = $this->session->get("request-catalog")->category_id ?: 0;

    $build = $this->component->catalog->buildQuery($_POST, $category_id, $this->session->get("geo"));

    if($build){
        $data = $this->model->ads_data->pagination(true)->page($page)->output($this->settings->out_default_count_items)->sort($sort)->getAll($build["query"], $build["params"]);
    }

    if($data){

        if($page <= $this->pagination->pages()){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $ids[] = $value->id;

                $content .= $this->component->advertising->outInResults($key, ["col-grid"=>"col-md-6 col-6 col-sm-6 col-lg-3"]);

                if($this->component->catalog->getViewItems($category_id) == "grid"){
                    $content .= $this->view->setParamsComponent(['value'=>$value])->includeComponent('items/grid.tpl');
                }else{
                    $content .= $this->view->setParamsComponent(['value'=>$value])->includeComponent('items/list.tpl');
                }

            }

            $this->component->catalog->updateCountDisplay($ids);

        }

        if($page + 1 <= $this->pagination->pages()){

            $result = '

               <div class="row row-cols-2 g-2 g-lg-3" style="display: none;" >

                  '.$content.'

               </div>

               <div class="text-center" >
                  <button class="btn-custom button-color-scheme1 actionShowMoreItems" >'.translate("tr_11d9e7ea0320006d822a967777abd16a").'</button>
               </div>

            ';

        }else{

            $data = $this->component->ads->getAdsByDistance($_POST, $category_id, $ids);

            if($data){

                $result = '

                   <div class="row row-cols-2 g-2 g-lg-3" style="display: none;" >

                      '.$content.'

                   </div>

                   <div class="text-center mt15" >
                      <p>'.translate("tr_6b377edee6db2cf591176951b7cd497e").'</p>
                   </div>

                   <h4 class="title-nearest-cities" >'.translate("tr_dbd2bb1804750454fd795cc36924bf3b").'</h4>

                   <div class="row row-cols-2 g-2 g-lg-3" >

                      '.$data.'

                   </div>

                ';

            }else{

                $result = '

                   <div class="row row-cols-2 g-2 g-lg-3" style="display: none;" >

                      '.$content.'

                   </div>

                   <div class="text-center mt15" >
                      <p>'.translate("tr_6b377edee6db2cf591176951b7cd497e").'</p>
                   </div>

                ';

            }

        }

    }else{

        $data = $this->component->ads->getAdsByDistance($_POST, $category_id);

        if($data){

            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h4>
                  <p>'.translate("tr_a7b03ac2b15fd0bff35a274c8b603c63").'</p>
                  <p>'.translate("tr_e9d264db2a7d22c56ac22e8750838d49").'</p>

                  <h4 class="title-nearest-cities" >'.translate("tr_dbd2bb1804750454fd795cc36924bf3b").'</h4>

                  <div class="row row-cols-2 g-2 g-lg-3" >

                     '.$data.'

                  </div>

               </div>

            ';       

        }else{

            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h4>
                  <p>'.translate("tr_a7b03ac2b15fd0bff35a274c8b603c63").'</p>
                  <p>'.translate("tr_e9d264db2a7d22c56ac22e8750838d49").'</p>

               </div>

            '; 

        }  

    }

    return json_answer(["content"=>$result]);

}

public function loadSubcategories(){

    $content = '';

    $content = $this->component->ads_categories->outReverseCategories($_POST["id"]);

    ob_start();

    echo $this->component->catalog->buildParamsForm([], $_POST["id"], false);

    $filters = ob_get_clean();

    return json_answer(["content"=>$content, "filters"=>$filters]);

}

public function saveSearch(){

    $result = $this->component->profile->saveCatalogSearch($_POST, $this->user->data->id);
    return json_answer($result);

}

public function searchItemsCombined(){

    $result = $this->component->search->searchItemsCombined($_POST["query"], $this->user->data->id);

    return json_answer($result);

}



 }