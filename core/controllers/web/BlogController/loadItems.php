public function loadItems()
{   

    $content = '';
    $data = [];

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;

    $this->pagination->request($_POST);

    if(intval($_POST['category_id'])){
        $data = $this->model->blog_posts->pagination(true)->page($_POST['page'])->output($this->settings->out_default_count_items_blog)->sort('id desc')->getAll("status=? and category_id IN(".$this->component->blog_categories->joinId($_POST['category_id'])->getParentIds($_POST['category_id']).")", [1]);
    }else{
        $data = $this->model->blog_posts->pagination(true)->page($_POST['page'])->output($this->settings->out_default_count_items_blog)->sort('id desc')->getAll("status=?", [1]);
    }

    if($data){

        if($page <= $this->pagination->pages()){

            foreach ($data as $key => $value) {

                $content .= $this->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/blog-grid.tpl');

            }

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

            ';

        }

    }else{

        if($_POST['category_id']){
            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_01fc6515f20863a6d905efd8a323cda8").'</h4>
                  <p>'.translate("tr_3a0ed9450b27faa7c05ead7caac6bbdc").'</p>

               </div>

            ';    
        }else{
            $result = '

               <div class="catalog-not-found" >

                  <h4>'.translate("tr_01fc6515f20863a6d905efd8a323cda8").'</h4>

               </div>

            ';
        }            

    }

    return json_answer(["content"=>$result]);

}