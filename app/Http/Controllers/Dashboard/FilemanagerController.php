<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class FilemanagerController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function deleteFile(){   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if(strpos($_POST['name'], "./") !== false || strpos($_POST['name'], "../") !== false){
        return json_answer(['status'=>false]);
    }

    $this->storage->path('images')->name($_POST['name'])->delete();

    return json_answer(['status'=>true]);

}

public function loadFiles(){   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $result = [];

    $content = '
    <form class="filemanager-backend-form" >
        <div class="filemanager-backend-area-add" > <span><i class="ti ti-download"></i> '.translate("tr_23641d8e2ebacd0eb8382d66d9ab9d3e").'</span> </div>
        <input type="file" name="filemanager_upload_file" class="filemanager-backend-input-upload" accept="image/*" />
    </form>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th></th>
            <th><span>'.translate("tr_602680ed8916dcc039882172ef089256").'</span></th>
            <th><span>'.translate("tr_06d897a2b68c63493b65390fe35e7a2a").'</span></th>
            <th><span>'.translate("tr_242d53ac6b9faa76504d0b3fc7851853").'</span></th>
            <th></th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
    ';

    $data = globRecursive($this->config->storage->images);

    if(count($data)){

        foreach ($data as $file){

            $info = getInfoFile($file->path);

            $result[filemtime($file->path)][] = '
                <tr class="filemanager-backend-file-item" data-name="'.$info->basename.'" data-path="'.path($file->path).'" data-clear-path="'.clearPath($file->path).'" >
                  <td><div class="filemanager-backend-file-item-image" ><img src="'.path($file->path, true).'" class="image-autofocus" /></div></td>
                  <td>'.$info->basename.'</td>
                  <td>'.($file->folder?:'/').'</td>
                  <td>'.$this->datetime->outDate(filemtime($file->path)).'</td>
                  <td class="text-end" >

                    <div class="flex-column flex-md-row align-items-center text-end">

                      <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light filemanager-backend-file-delete" data-name="'.$file->folder.$info->basename.'" >
                        <span class="ti ti-xs ti-trash"></span>
                      </button>

                    </div>

                  </td>
                </tr>
            ';

        }

        krsort($result);

        foreach ($result as $time => $nested) {
            foreach ($nested as $value) {
                $content .= $value;
            }
        }

    }     

    $content .= '
        </tbody>
      </table>
    </div>        
    ';

    return json_answer(['content'=>$content]);

}

public function main(){   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/filemanager.js\" type=\"module\" ></script>"]);

}

public function uploadFiles(){   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $resultUpload = $this->storage->files($_FILES['filemanager_upload_file'])->path('images')->extList('images')->use("resize")->upload();

    return json_answer(['status'=>true]);

}



 }