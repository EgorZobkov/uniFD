<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class StorageController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function storageSave(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];
        $generatedName = md5(time().'-'.uniqid());
        $extension = 'webp';

        if($_POST["action"] == "storyAdd"){

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

            }

            return json_answer(["name"=>$upload["name"], "link"=>$this->storage->name($upload["name"])->path('temp')->host(true)->get()]);

        }elseif($_POST["action"] == "verificationPhotoAdd"){

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                $this->storage->encryptFile($this->config->storage->temp.'/'.$generatedName.'.'.$extension); 

            }

            return json_answer(["name"=>$generatedName.'.'.$extension, "link"=>$this->storage->host(true)->getAssetImage("6383224500768844.webp")]);

        }elseif($_POST["action"] == "createAd"){

            if($_POST["format_type"] == "image"){
                if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){
                    $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->watermark(true)->resize();
                }
            }elseif($_POST["format_type"] == "video" && $this->settings->board_publication_add_video_status){
                if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.mp4', base64_decode(htmlspecialchars_decode($_POST['asset'])))){
                    $upload = $this->video->file($this->config->storage->temp.'/'.$generatedName.'.mp4')->name($generatedName)->saveToImage($this->config->storage->temp)->saveImagePreview();
                    $upload["name"] = $upload["name_image"];
                }
            }

            return json_answer(["name"=>$upload["name"], "link"=>$this->storage->name($upload["name"])->path('temp')->host(true)->get(), "type"=>$_POST["format_type"] ?: null]);

        }elseif($_POST["action"] == "userAvatar"){

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

            }

            return json_answer(["name"=>$upload["name"], "link"=>$this->storage->name($upload["name"])->path('temp')->host(true)->get()]);

        }elseif($_POST["action"] == "shopLogo"){

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

            }

            return json_answer(["name"=>$upload["name"], "link"=>$this->storage->name($upload["name"])->path('temp')->host(true)->get()]);

        }elseif($_POST["action"] == "shopBanner"){

            if($this->model->shops_banners->count("user_id=?", [$_POST['user_id']]) >= $this->settings->shop_max_banners){
                return json_answer(["answer"=>translate("tr_e6000795b8f4845f6f660f49de980e11")]);
            }

            $shop = $this->model->shops->find("user_id=?", [$_POST['user_id']]);

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                if($shop){

                    $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

                    $image = $this->storage->uploadAttachFiles([$generatedName.'.'.$extension], $this->config->storage->users->attached);

                    $this->model->shops_banners->insert(["user_id"=>$_POST['user_id'], "shop_id"=>$shop->id, "image"=>$image[0]]);

                    $this->event->editShop(["user_id"=>$_POST['user_id'], "shop_id"=>$shop->id, "action"=>"add_banner_shop"]);

                    return json_answer(["name"=>basename($image[0]), "link"=>$this->storage->name($image[0])->host(true)->get()]);

                }

            }

            return json_answer(null);

        }elseif($_POST["action"] == "chatAttach"){

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

            }

            return json_answer(["name"=>$upload["name"], "link"=>$this->storage->name($upload["name"])->path('temp')->host(true)->get()]);

        }elseif($_POST["action"] == "reviewAdd"){

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

            }

            return json_answer(["name"=>$upload["name"], "link"=>$this->storage->name($upload["name"])->path('temp')->host(true)->get()]);

        }elseif($_POST["action"] == "dealDisput"){

            if(_file_put_contents($this->config->storage->temp.'/'.$generatedName.'.'.$extension, base64_decode(htmlspecialchars_decode($_POST['asset'])))){

                $upload = $this->image->path($this->config->storage->temp)->name($generatedName.'.'.$extension)->saveTo($this->config->storage->temp)->resize();

            }

            return json_answer(["name"=>$upload["name"], "link"=>$this->storage->name($upload["name"])->path('temp')->host(true)->get()]);

        }

        

    }

}