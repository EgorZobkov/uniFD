<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class BlogController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getPosts(){

        $posts = [];
        $images = [];
        $categories = [];

        $page = (int)$_GET["page"] ? (int)$_GET["page"] : 1;

        if(intval($_GET['cat_id'])){
            $data = $this->model->blog_posts->pagination(true)->page($page)->output($this->settings->out_default_count_items_blog)->sort('id desc')->getAll("status=? and category_id IN(".$this->component->blog_categories->joinId($_GET['cat_id'])->getParentIds($_GET['cat_id']).")", [1]);
        }else{
            $data = $this->model->blog_posts->pagination(true)->page($page)->output($this->settings->out_default_count_items_blog)->sort('id desc')->getAll("status=?", [1]);
        } 

        if($data){

            foreach ($data as $key => $value) {

                $posts[] = [
                    "id"=>$value["id"],
                    "title"=>translateFieldReplace($value, "title", $_REQUEST["lang_iso"]),
                    "image"=>$this->storage->name($value["image"])->host(true)->get(),
                    "content"=>_json_decode($value["content"]),
                    "time_create"=>$this->datetime->outDate($value["time_create"]),
                    "count_view"=>$this->component->blog->getViews($value["id"]),
                    "cat_name"=>translateFieldReplace($this->component->blog_categories->categories[$value["category_id"]], "name", $_REQUEST["lang_iso"]),
                ];

            }

        }

        $getCategories = $this->model->blog_categories->getAll("status=?", [1]);
        if($getCategories){
            foreach ($getCategories as $key => $value) {

                $count = $this->model->blog_posts->count("category_id=?", [$value["id"]]);

                $categories[] = ["id"=>$value["id"], "name"=>$value["name"], "count"=>$count];

            }
        }

        return json_answer(["data"=>$posts, "categories"=>$categories ?: null, "count"=>$this->pagination->totalItems . ' ' . endingWord($this->pagination->totalItems, translate("tr_7c8b7b6900916cc5366c3a7ea3a0610f"), translate("tr_798198dcae3df095f203892f5bd55117"), translate("tr_5a7b240b53441a9854de63c357a27fa2")), "pages"=>$this->pagination->totalPages, "advertisement"=>null]);

    }

    public function getPost(){

        $result = [];
        $post = $this->model->blog_posts->find("id=? and status=?", [intval($_GET["id"]), 1]);

        if($post){

            $this->component->blog->fixView($post->id, $_GET["user_id"], $_GET['ip']);

            $result = [
                "id"=>$post->id,
                "title"=>translateFieldReplace($post, "title", $_REQUEST["lang_iso"]),
                "image"=>$this->storage->name($post->image)->host(true)->get(),
                "content"=>$this->api->outPostContent($post),
                "time_create"=>$this->datetime->outDate($post->time_create),
                "count_view"=>$this->component->blog->getViews($post->id),
                "cat_name"=>translateFieldReplace($this->component->blog_categories->categories[$post->category_id], "name", $_REQUEST["lang_iso"]),
            ];

        }

        return json_answer(["data"=>$result]);

    }

}