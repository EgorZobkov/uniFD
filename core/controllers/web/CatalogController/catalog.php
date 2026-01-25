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