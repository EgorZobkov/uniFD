<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class StoriesController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function usersStories(){   

        return json_answer(["data"=>$this->api->usersStoriesData() ?: null]);

    }

    public function userStories(){

        $user_id = (int)$_GET['story_user_id'];

        return json_answer(["data"=>$this->api->userStoriesData($user_id) ?: []]);

    }

    public function upload(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];
        $extensions_image = $this->settings->allowed_extensions_images;
        $extensions_video = $this->settings->allowed_extensions_videos;
        $generatedName = md5(time().'-'.uniqid());
        $type = '';

        if($_POST["format_type"] == "image"){
            $extension = 'webp';
            $type = 'image';
        }else{
            $extension = 'mp4';
            $type = 'video';
        }      

        if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode($_POST['data']))){

            $extension = getInfoFile($this->config->storage->temp.'/'.$generatedName.'.'.$extension)->extension;
            $filesize = filesize($this->config->storage->temp.'/'.$generatedName.'.'.$extension); 

            if(compareValues($extensions_image, $extension)){

                if($filesize < $this->settings->stories_max_size_image*1024*1024){

                    $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

                    $result = $this->api->storiesPublication(["name"=>$generatedName, "type"=>$type], $_POST['user_id']);

                    if(!$result["status"]){
                        return json_answer(["stories"=>$this->api->usersStoriesData() ?: null, "answer"=>$result["answer"]]);
                    }

                }

            }elseif(compareValues($extensions_video, $extension)){
      
                if($filesize < $this->settings->stories_max_size_video*1024*1024){

                    $upload = $this->video->file($this->config->storage->temp.'/'.$generatedName.'.mp4')->name($generatedName)->saveToImage($this->config->storage->temp)->saveImagePreview();

                    $result = $this->api->storiesPublication(["name"=>$generatedName, "type"=>$type, "video_duration"=>intval($_POST['video_duration']) ? intval($_POST['video_duration'] / 1000) : 0], $_POST['user_id']);

                    if(!$result["status"]){
                        return json_answer(["stories"=>$this->api->usersStoriesData() ?: null, "answer"=>$result["answer"]]);
                    }

                }

            }

        }

        return json_answer(["stories"=>$this->api->usersStoriesData() ?: null]);

    }


    public function updateViewStory(){   

        $story_id = $_POST["id"];
        $session_id = $_POST["session_id"];

        if($story_id && $session_id){

            $check = $this->model->stories_media_views->find("story_id=? and session_id=?", [$story_id,$session_id]);

            if(!$check){
                $this->model->stories_media_views->insert(["story_id"=>$story_id, "user_id"=>$user_id?:0, "session_id"=>$session_id?:null]);
            }

        }

        return json_answer(["status"=>true]);

    }

    public function deleteStory(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }
        
        $this->component->stories->delete($_POST["id"], $_POST["user_id"]);

        return json_answer(["status"=>true]);

    }

}