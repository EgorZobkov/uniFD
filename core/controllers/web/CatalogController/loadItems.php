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