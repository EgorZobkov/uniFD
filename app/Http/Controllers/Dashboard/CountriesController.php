<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class CountriesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addCitiesFromList()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->validation->requiredField($_POST['country_id'])->status == false){
        $answer['country_id'] = $this->validation->error;
    }

    if(empty($answer)){

        $country_id = 0;

        $country = $this->system->uniApi("country_load", ["country_id"=>$_POST['country_id']]);

        if($country){

            $country["temp_id"] = $country["id"];
            $country["status_api_import"] = 1;

            unset($country["id"]);

            $country_id = $this->model->geo_countries->insert($country);

        }

        if($country_id){

            $regions = $this->system->uniApi("regions_load", ["country_id"=>$_POST['country_id']]);

            if($regions){
                foreach ($regions as $key => $value) {
                    $value["temp_id"] = $value["id"];
                    unset($value["id"]);
                    $value["country_id"] = $country_id;
                    $this->model->geo_regions->insert($value);
                }
            }

            $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        }else{

            $this->session->setNotifyDashboard('error', code_answer("something_went_wrong"));

        }

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function addCity()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $_POST['latitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['latitude']);
    $_POST['longitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['longitude']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['latitude'])->status == false){
        $answer['latitude'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['longitude'])->status == false){
        $answer['longitude'] = $this->validation->error;
    }
 
    if(empty($answer)){

        if($_POST['region_id']){
            $getRegion = $this->model->geo_regions->find("id=?", [$_POST['region_id']]);
        }

        $getCountry = $this->model->geo_countries->find("id=?", [$_POST['country_id']]);

        $this->model->geo_cities->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "latitude"=>$_POST['latitude'], "longitude"=>$_POST['longitude'], "region_id"=>$_POST['region_id'], "country_id"=>$_POST['country_id'], "region_name"=>$getRegion->name ?: null, "country_name"=>$getCountry->name ?: null, "location_type_code"=>$_POST['location_type_code'],'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function addCityDistrict()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->geo_cities_districts->insert(["name"=>$_POST['name'], "city_id"=>$_POST['city_id']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function addCityMetro()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['color'])->status == false){
        $answer['color'] = $this->validation->error;
    }

    if(empty($answer)){

        $insert_id = $this->model->geo_cities_metro->insert(["name"=>$_POST['name'],"color"=>$_POST['color'], "city_id"=>$_POST['city_id']]);

        if($_POST['stations']){
            foreach ($_POST['stations']['add'] as $key => $station) {
                if(trim($station)){
                    $this->model->geo_cities_metro->insert(["name"=>$station, "parent_id"=>$insert_id, "city_id"=>$_POST['city_id']]);
                }
            }
        }

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function addCountry()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $_POST['latitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['latitude']);
    $_POST['longitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['longitude']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['iso'])->status == false){
        $answer['iso'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['latitude'])->status == false){
        $answer['latitude'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['longitude'])->status == false){
        $answer['longitude'] = $this->validation->error;
    }
 
    if(empty($answer)){

        $insert_id = $this->model->geo_countries->insert(["status"=>(int)$_POST['status'], "default_status"=>(int)$_POST['default'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "code"=>_strtoupper($_POST['iso']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'], "image"=>$_POST["manager_image"] ?: null,'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']]);

        if($_POST['default']){
            $this->model->geo_countries->update(["default_status"=>0], ["id!=?", [$insert_id]]);
        }

        $this->component->geo->updateActiveCountries();

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function addRegion()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $_POST['latitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['latitude']);
    $_POST['longitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['longitude']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['latitude'])->status == false){
        $answer['latitude'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['longitude'])->status == false){
        $answer['longitude'] = $this->validation->error;
    }
 
    if(empty($answer)){

        $this->model->geo_regions->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'], "country_id"=>$_POST['country_id'],'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function cardCity($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $data = $this->model->geo_cities->find('id=?',[$id]);

    if(!$data){
        abort(404);
    }

    $data->country = $this->model->geo_countries->find('id=?',[$data->country_id]);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries"),$data->country->name=>$this->router->getRoute("dashboard-country-card", [$data->country->id]),$data->name=>null]]]);

    $this->view->setParamsPreload(["city_id"=>$id]);

    return $this->view->preload('countries/city-card', ["data"=>(object)$data, "title"=>$data->name]);

}

public function cardCityMetro($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $data = $this->model->geo_cities->find('id=?',[$id]);

    if(!$data){
        abort(404);
    }

    $data->country = $this->model->geo_countries->find('id=?',[$data->country_id]);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries"),$data->country->name=>$this->router->getRoute("dashboard-country-card", [$data->country->id]),$data->name=>null]]]);

    $this->view->setParamsPreload(["city_id"=>$id,"country_id"=>$data->country_id]);

    return $this->view->preload('countries/metro-card', ["data"=>(object)$data, "title"=>$data->name]);

}

public function cardCountry($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $data = $this->model->geo_countries->find('id=?',[$id]);

    if(!$data){
        abort(404);
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries"),$data->name=>null]]]);

    $this->view->setParamsPreload(["country_id"=>$id]);

    return $this->view->preload('countries/country-card', ["data"=>(object)$data, "title"=>$data->name]);

}

public function cardRegions($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $data = $this->model->geo_countries->find('id=?',[$id]);

    if(!$data){
        abort(404);
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries"),$data->name=>$this->router->getRoute("dashboard-country-card", [$id]),translate("tr_81b8d9aded466a2ad70e6dcdd34d22a2")=>null]]]);

    $this->view->setParamsPreload(["country_id"=>$id]);

    return $this->view->preload('countries/regions-card', ["data"=>(object)$data, "title"=>$data->name]);

}

public function changeCityFavorite()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $find = $this->model->geo_cities->find("id=?", [$_POST["id"]]);

    if($find->favorite){
        $this->model->geo_cities->cacheKey(["id"=>$_POST["id"]])->update(["favorite"=>0], $_POST["id"]);
        return json_answer(["status"=>false]);
    }else{
        $this->model->geo_cities->cacheKey(["id"=>$_POST["id"]])->update(["favorite"=>1], $_POST["id"]);
        return json_answer(["status"=>true]);
    }

}

public function countries()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/countries.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_f492287bd5434c17eca5eac67c5ad4c4")=>$this->router->getRoute("dashboard-countries")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_f492287bd5434c17eca5eac67c5ad4c4"),"page_icon"=>"ti-world","favorite_status"=>true]]);

    return $this->view->preload('countries/countries', ["data"=>(object)$data, "title"=>translate("tr_f492287bd5434c17eca5eac67c5ad4c4")]);

}

public function deleteCity()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_cities->delete('id=?', [$_POST['id']]);
    $this->model->geo_cities_districts->delete('city_id=?', [$_POST['id']]);
    $this->model->geo_cities_metro->delete('city_id=?', [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteCityDistrict()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_cities_districts->delete('id=?', [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteCityMetro()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_cities_metro->delete('id=?', [$_POST['id']]);
    $this->model->geo_cities_metro->delete('parent_id=?', [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteCountry()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_countries->delete('id=?', [$_POST['id']]);
    $this->model->geo_regions->delete('country_id=?', [$_POST['id']]);
    $this->model->geo_cities->delete('country_id=?', [$_POST['id']]);

    $this->component->geo->updateActiveCountries();

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteRegion()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->geo_regions->delete('id=?', [$_POST['id']]);
    $this->model->geo_cities->delete('region_id=?', [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function editCity()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_cities->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    $_POST['latitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['latitude']);
    $_POST['longitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['longitude']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['latitude'])->status == false){
        $answer['latitude'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['longitude'])->status == false){
        $answer['longitude'] = $this->validation->error;
    }     

    if(empty($answer)){

        if($_POST['region_id']){
            $getRegion = $this->model->geo_regions->find("id=?", [$_POST['region_id']]);
        }

        $this->model->geo_cities->cacheKey(["id"=>$data->id])->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "latitude"=>$_POST['latitude'], "longitude"=>$_POST['longitude'], "region_id"=>$_POST['region_id'], "region_name"=>$getRegion->name ?: null, "location_type_code"=>$_POST['location_type_code'],'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']], $data->id);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}

public function editCityDistrict()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_cities_districts->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->geo_cities_districts->cacheKey(["id"=>$data->id])->update(["name"=>$_POST['name']], $data->id);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}

public function editCityMetro()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_cities_metro->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['color'])->status == false){
        $answer['color'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->geo_cities_metro->cacheKey(["id"=>$data->id])->update(["name"=>$_POST['name'],"color"=>$_POST['color']], $data->id);

        if($_POST["stations"]){
            $current_ids = [];
            if(is_array($_POST["stations"])){
                foreach ($_POST["stations"] as $action => $nested) {
                    foreach ($nested as $id => $value) {
                        if($action == "add"){
                            if(trim($value)){
                                $current_ids[] = $this->model->geo_cities_metro->insert(["name"=>$value, "parent_id"=>$data->id, "city_id"=>$data->city_id]);
                            }
                        }
                        if($action == "update"){
                            if(trim($value)){
                                $this->model->geo_cities_metro->cacheKey(["id"=>$id])->update(["name"=>$value],$id);
                                $current_ids[] = $id;
                            }
                        }
                    }  
                }
                if($current_ids){
                    $this->model->geo_cities_metro->delete("id NOT IN(".implode(",", $current_ids).") and parent_id=?", [$data->id]);
                }
            }
        }else{
            $this->model->geo_cities_metro->delete("parent_id=?", [$data->id]);
        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}

public function editCountry()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_countries->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>"Запись не найдена"]);

    $_POST['latitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['latitude']);
    $_POST['longitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['longitude']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['iso'])->status == false){
        $answer['iso'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['latitude'])->status == false){
        $answer['latitude'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['longitude'])->status == false){
        $answer['longitude'] = $this->validation->error;
    }     

    if(empty($answer)){

        $this->model->geo_countries->cacheKey(["id"=>$data->id])->update(["status"=>(int)$_POST['status'], "default_status"=>(int)$_POST['default'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "code"=>_strtoupper($_POST['iso']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'], "image"=>$_POST["manager_image"] ?: null,'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']], $data->id);

        $this->model->geo_cities->cacheKey(["country_id"=>$data->id])->update(["country_name"=>$_POST['name']],["country_id=?", [$data->id]]);

        if($_POST['default']){
            $this->model->geo_countries->update(["default_status"=>0], ["id!=?", [$data->id]]);
        }

        $this->component->geo->updateActiveCountries();

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}

public function editRegion()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_regions->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    $_POST['latitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['latitude']);
    $_POST['longitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['longitude']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['latitude'])->status == false){
        $answer['latitude'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['longitude'])->status == false){
        $answer['longitude'] = $this->validation->error;
    }     

    if(empty($answer)){

        $this->model->geo_regions->cacheKey(["id"=>$data->id])->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'],'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']], $data->id);

        $this->model->geo_cities->update(["region_name"=>$_POST['name']], ["region_id=?", [$data->id]]);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}

public function loadCountriesList()
{   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $result = '';

    $countries_list = $this->system->uniApi("countries_list");

    $result = '<option value="" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</option>';

    if($countries_list){
      foreach ($countries_list as $key => $value) {
         $result .= '<option value="'.$value["id"].'" >'.$value["name"].'</option>';
      }
    }

    return json_answer(["status"=>true, "content"=>$result]);

}

public function loadEditCity()
{

    $data = $this->model->geo_cities->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-city.tpl')]);
    }

}

public function loadEditCityDistrict()
{

    $data = $this->model->geo_cities_districts->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-city-district.tpl')]);
    }

}

public function loadEditCityMetro()
{

    $data = $this->model->geo_cities_metro->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-city-metro.tpl')]);
    }

}

public function loadEditCountry()
{

    $data = $this->model->geo_countries->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-country.tpl')]);
    }

}

public function loadEditRegion()
{

    $data = $this->model->geo_regions->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-region.tpl')]);
    }

}



 }