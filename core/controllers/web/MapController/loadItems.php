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