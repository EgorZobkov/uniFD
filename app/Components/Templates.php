<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Templates
{

 public $alias = "templates";

 public function addPageByMainCatalog($name=""){
    global $app;

    $filename = md5(uniqid());

    if(_file_put_contents($app->config->resource->view->web->path.'/'.$filename.'.tpl', $this->mainCatalogTplBody())){
        $insert_id = $app->model->template_pages->insert(["status"=>1, "name"=>$name, "template_name"=>$filename, "edit_status"=>0]);
        $app->model->seo_content->insert(["page_id"=>$insert_id]);
        return $insert_id; 
    }       

}

public function defaultTplBody(){
    return trim('
    {% extends index.tpl %}

    {% block content %}

    <div class="container" >

        <h1 class="font-bold mt20 mb20">{{ $seo->h1 }}</h1>
             
        <p>{{ $seo->text }}</p>

        <p>Чтобы настроить заголовок и текст перейдите в раздел SEO и выберите данную страницу.</p>

        <p>To customize the title and text, go to the SEO section and select this page.</p>

        <p>🫶🏻✌🏻❤️</p>

    </div>

    {% endblock %}
    ');
}

public function fileExists($name=null, $section=null){
    global $app;

    if(isset($name)){

        if($section == "pages"){
            if(file_exists($app->config->resource->view->web->path."/".$name.".tpl")){
                return true;
            }
        }elseif($section == "css"){
            if(file_exists($app->config->resource->assets->web->css."/".$name.".css")){
                return true;
            }
        }elseif($section == "js"){
            if(file_exists($app->config->resource->assets->web->js."/".$name.".js")){
                return true;
            }
        }

    }

    return false;

}

public function getCss(){
    global $app;

    $list = glob($app->config->resource->assets->web->css.'/*.css');

    if(count($list)){
        foreach ($list as $file){
            $filename = getInfoFile($file)->filename;
            if($filename == "main"){
                echo '<a href="'.$app->router->getRoute("dashboard-template-view-css", [$filename]).'" class="list-group-item list-group-item-action d-flex justify-content-between"><div class="li-wrapper d-flex justify-content-start align-items-center" >'.$filename.'</div><div><span class="badge badge-small bg-label-warning mb-1">'.translate("tr_57909986c8d97e90e748540935ffb5b6").'</span></div></a>';
            }else{
                echo '<a href="'.$app->router->getRoute("dashboard-template-view-css", [$filename]).'" class="list-group-item list-group-item-action">'.$filename.'</a>';
            }
        }
    }

}

public function getJs(){
    global $app;

    $list = glob($app->config->resource->assets->web->js.'/*.js');

    if(count($list)){
        foreach ($list as $file){
            $filename = getInfoFile($file)->filename;
            echo '<a href="'.$app->router->getRoute("dashboard-template-view-js", [$filename]).'" class="list-group-item list-group-item-action">'.$filename.'</a>';
        }
    }

}

public function getPages(){
    global $app;

    $getSections = $app->model->template_pages->sort("id desc")->getAll();
    if($getSections){
      foreach ($getSections as $value) {

         $edit_button = '';

         if($value["edit_status"]){
            $edit_button = '
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light actionTemplatesLoadEditPage" data-id="'.$value["id"].'" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>
            ';
         }

         if($value["freeze"]){
             echo '
              <a href="'.$app->router->getRoute("dashboard-template-view-page", [$value["id"]]).'" class="list-group-item list-group-item-action d-flex justify-content-between">
                <div class="li-wrapper d-flex justify-content-start align-items-center">
                  <div class="list-content">
                    '.translateField($value["name"]).'
                  </div>
                </div>
                <div>
                    <span class="badge badge-small bg-label-warning">'.translate("tr_2b7d9946852ba858f7a8498670750958").'</span>
                </div>
              </a>
             ';
         }else{
             echo '
              <a href="'.$app->router->getRoute("dashboard-template-view-page", [$value["id"]]).'" class="list-group-item list-group-item-action d-flex justify-content-between">
                <div class="li-wrapper d-flex justify-content-start align-items-center">
                  <div class="list-content">
                    '.translateField($value["name"]).'
                  </div>
                </div>
                <div>
                  '.$edit_button.'
                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light actionTemplatesDeletePage" data-id="'.$value["id"].'" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>
                </div>
              </a>
             ';                
         }

      }
    }

}

public function include($name=null, $section=null){
    global $app;

    if(isset($name)){

        if($section == "pages"){
            if(file_exists($app->config->resource->view->web->path."/".$name.".tpl")){

                return _file_get_contents($app->config->resource->view->web->path."/".$name.".tpl");

            }
        }elseif($section == "css"){
            if(file_exists($app->config->resource->assets->web->css."/".$name.".css")){

                return _file_get_contents($app->config->resource->assets->web->css."/".$name.".css");

            }
        }elseif($section == "js"){
            if(file_exists($app->config->resource->assets->web->js."/".$name.".js")){

                return _file_get_contents($app->config->resource->assets->web->js."/".$name.".js");

            }
        }

    }

    return '';

}

public function mainCatalogTplBody(){
    global $app;

    if(file_exists($app->config->resource->view->web->path."/catalog.tpl")){
        return _file_get_contents($app->config->resource->view->web->path."/catalog.tpl");
    }

    return $this->defaultTplBody();

}

public function outPagesOptions(){
    global $app;

    $getPages = $app->model->template_pages->sort("id desc")->getAll("freeze=?", [0]);
    if($getPages){
      foreach ($getPages as $value) {

        echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';

      }
    }

}

public function outSections(){
    global $app;

    ?>

      <li class="nav-item" >
        <a href="<?php echo $app->router->getRoute('dashboard-templates'); ?>" class="nav-link <?php if($app->router->currentRoute->name == "dashboard-templates"){ echo 'active-light'; } ?>" >
          <i class="ti ti-file me-1"></i> <?php echo translate("tr_759494086041808a9550c81060a3a6ea"); ?>
        </a>
      </li>
      <li class="nav-item" >
        <a href="<?php echo $app->router->getRoute('dashboard-template-css'); ?>" class="nav-link <?php if($app->router->currentRoute->name == "dashboard-template-css"){ echo 'active-light'; } ?>" >
          <i class="ti ti-paint me-1"></i> <?php echo translate("tr_e615eed31d3e3fcdbe9e1b50f3b30ca8"); ?>
        </a>
      </li>
      <li class="nav-item" >
        <a href="<?php echo $app->router->getRoute('dashboard-template-js'); ?>" class="nav-link <?php if($app->router->currentRoute->name == "dashboard-template-js"){ echo 'active-light'; } ?>" >
          <i class="ti ti-script me-1"></i> <?php echo translate("tr_b092423caea6bd0b943b462485c08d9f"); ?>
        </a>
      </li>

    <?php

}

public function outTplPageAlias($alias=null){
    global $app;

    return '{{ outLink("'.$alias.'") }}';

}



}