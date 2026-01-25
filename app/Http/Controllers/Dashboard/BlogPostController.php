<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class BlogPostController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function add()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }  

    if($this->validation->requiredField($_POST['category_id'])->status == false){
        $answer['category_id'] = $this->validation->error;
    } 

    if(empty($answer)){

        $post_id = $this->model->blog_posts->insert(["title"=>$_POST['title'], "image"=>$_POST['manager_image'] ?: null, "alias"=>slug($_POST['alias']), "category_id"=>(int)$_POST['category_id'], "status"=>(int)$_POST['status'], "time_create"=>$this->datetime->getDate(), "seo_desc"=>$_POST['seo_desc'] ?: null]);

        return json_answer(["status"=>true, "redirect"=>$this->router->getRoute('dashboard-blog-post-content', [$post_id])]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function contentSave()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $content = [];

    parse_str(urldecode($_POST['content']), $content);

    $this->model->blog_posts->update(["body"=>$content ? $_POST['body'] : null, "content"=>$content ? _json_encode($content["content"]) : null], $content['id']);

    return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

}

public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->blog->delete($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->blog_posts->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>false, "answer"=>code_answer("record_not_found")]);

    $answer = [];

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }  

    if($this->validation->requiredField($_POST['category_id'])->status == false){
        $answer['category_id'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->blog_posts->update(["title"=>$_POST['title'], "image"=>$_POST['manager_image'] ?: null, "alias"=>slug($_POST['alias']), "category_id"=>(int)$_POST['category_id'], "status"=>(int)$_POST['status'], "seo_desc"=>$_POST['seo_desc'] ?: null], $_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}

public function loadEdit()
{

    $data = $this->model->blog_posts->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('blog/load-edit-post.tpl')]);

}

public function multiDelete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->blog->multiDelete($_POST['ids_selected']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function postContent($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/blog.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/ckeditor/ckeditor.js\" type=\"module\" ></script>"]);

    $data = $this->model->blog_posts->find("id=?", [$id]);

    if(!$data){
        abort(404);
    }        

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_40479311ccd23f5d64eb927684429cbb")=>$this->router->getRoute("dashboard-blog-posts"),$data->title=>null]]]);

    return $this->view->preload('blog/post-content', ["data"=>$data, "title"=>$data->title]);

}

public function posts()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/blog.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_40479311ccd23f5d64eb927684429cbb")=>$this->router->getRoute("dashboard-blog-posts")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_40479311ccd23f5d64eb927684429cbb"),"page_icon"=>"ti-article","favorite_status"=>true]]);

    return $this->view->preload('blog/posts', ["title"=>translate("tr_40479311ccd23f5d64eb927684429cbb")]);

}

public function uploadImage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('blog')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        return json_answer(["status"=>true, "path"=>path($resultUpload["path"]), "clear_path"=>clearPath($resultUpload["path"])]);

    }

    return json_answer(["status"=>false]);

}



 }