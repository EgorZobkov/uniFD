public function loadItems()
{   

    $content = '';
    $data = [];
    $ids = [];
    $shop = [];

    $this->pagination->request($_POST);

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;
    $url = $_POST['url'] ? clearRequestURI(urldecode($_POST['url'])) : '';

    if($_POST["sort"] == "news"){
        $sort = 'id desc';
    }elseif($_POST["sort"] == "price_asc"){
        $sort = 'price asc';
    }elseif($_POST["sort"] == "price_desc"){
        $sort = 'price desc';
    }else{
        $sort = 'time_sorting desc';
    }

    if(trim($url, "/")){

        $url_explode = explode("/", trim($url, "/"));
        
        if($url_explode[1]){
            $shop = $this->model->shops->find("alias=?", [$url_explode[1]]);
        }

    }

    if(!$shop){
        return json_answer(["content"=>"<h4>".translate("tr_8767f9ec282489d3e8e29021d0967187")."</h4>"]);
    }

    $build = $this->component->catalog->buildQuery($_POST, $_POST["c_id"]);

    if($build){
        if($shop->user_id){
            $build["query"] = $build["query"] . " and user_id=?";
            $build["params"][] = $shop->user_id;
        }
        $data = $this->model->ads_data->pagination(true)->page($page)->output($this->settings->out_default_count_items)->sort($sort)->getAll($build["query"], $build["params"]);
    }

    if($data){

        if($page <= $this->pagination->pages()){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $ids[] = $value->id;

                if($this->component->catalog->getViewItems() == "grid"){
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

            $result = '

               <div class="row row-cols-2 g-2 g-lg-3" style="display: none;" >

                  '.$content.'

               </div>

               <div class="text-center mt15" >
                  <p>'.translate("tr_6b377edee6db2cf591176951b7cd497e").'</p>
               </div>

            ';

        }

    }else{

        $result = '

           <div class="catalog-not-found" >

              <h4>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h4>
              <p>'.translate("tr_a7b03ac2b15fd0bff35a274c8b603c63").'</p>
              <p>'.translate("tr_e9d264db2a7d22c56ac22e8750838d49").'</p>

           </div>

        ';            

    }

    return json_answer(["content"=>$result]);

}