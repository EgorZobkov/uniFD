<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class StoriesController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function delete()
{   

    $this->component->stories->delete($this->request->get('id'), $this->user->data->id);
    return json_answer(["status"=>true]);

}

public function load()
{   

    $result = $this->component->stories->load($this->request->get('id'), $this->user->data->id, $this->request->get('category_id'));
    return json_answer(["content"=>$result]);

}

public function publication()
{   

    $result = $this->component->stories->publication($this->request->request->all(), $this->user->data->id);
    return json_answer($result);

}

public function uploadAttach()
{   

    $result = $this->component->stories->uploadAttach($_FILES["attach_files"]);
    return json_answer($result);
 
}



 }