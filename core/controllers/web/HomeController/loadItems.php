public function loadItems()
{   

    $content = '';
    $data = [];
    $ids = [];

    $page = (int)$_POST["page"] ?: 1;

    $geo = $this->session->get("geo");

    $this->pagination->request($_POST);

    $data = $this->model->ads_data->pagination(true)->page($page)->output($this->settings->out_default_count_items_home)->sort("time_sorting desc")->geo($geo)->getAll("status=?", [1]);

    if($data){

        if($page <= $this->pagination->pages()){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $ids[] = $value->id;

                $content .= $this->component->advertising->outInResults($key, ["col-grid"=>"col"]);

                $content .= $this->view->setParamsComponent(['value'=>$value])->includeComponent('items/home-grid.tpl');

            }

            $this->component->catalog->updateCountDisplay($ids);

        }

        if($page + 1 <= $this->pagination->pages()){

            $result = '
               <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" style="display: none;" >
                  '.$content.'
               </div>
               <div class="text-center" >
                  <button class="btn-custom button-color-scheme1 actionShowMoreItems" >'.translate("tr_11d9e7ea0320006d822a967777abd16a").'</button>
               </div>
            ';

        }else{
            $result = '
               <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" >
                  '.$content.'
               </div>
            ';
        }

    }else{
        if($geo){
            $result = '
               <div class="text-start" >
                  <p>'.translate("tr_65cd7b770f254b37e16a5187b91b0072").' "'.$geo->name.'" '.translate("tr_56952e12d9f7d5f3d0d08b34016f8fa8").'</p>
               </div>
            ';    
        }else{
            $result = '
               <div class="text-start" >
                  <p>'.translate("tr_698ee392dad3099a37dae5c98118fb2d").'</p>
               </div>
            ';
        }    
    }

    return json_answer(["content"=>$result]);

}