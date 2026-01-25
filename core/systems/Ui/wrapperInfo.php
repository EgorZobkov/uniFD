public function wrapperInfo($code=null, $params=[]){
    global $app;

    if($code == "dashboard-improv"){

        $title = "";
        $subtitle = "";
        $image = "";

        if($params){

            if($params["search"]){
                return '
                <div class="wrapper-image-no-data" >
                    <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
                    <h3>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h3>
                    <p>'.translate("tr_2ddad39a6fc8e396dca6763bd2d4b93d").'</p>
                </div>
                ';
            }elseif($params["filter"]){
                return '
                <div class="wrapper-image-no-data" >
                    <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
                    <h3>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h3>
                    <p>'.translate("tr_5bc04afa29bed6d07675bb927f5cbfb4").'</p>
                </div>
                ';
            }else{
               if($params["title"]){
                    $title = '<h3>'.$params["title"].'</h3>';
               }
               if($params["subtitle"] != null){
                   if($params["subtitle"]){
                        $subtitle = '<p>'.$params["subtitle"].'</p>';
                   }else{
                        $subtitle = '<p>'.translate("tr_cd49d589a08b40c4c940a29bad33f428").'</p>';
                   }
               }
            }
            
            if($params["image"]){
                $image = '<img src="'.$app->storage->getAssetImage($params["image"]).'" />';
            }else{
                $image = '<img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />';
            }

            if($title){
                return '
                <div class="wrapper-image-no-data" >
                    '.$image.'
                    '.$title.'
                    '.$subtitle.'
                </div>
                '; 

            }

        }
       
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
            <h3>'.translate("tr_26254ca95ba8d208a1674e9b23653d50").'</h3>
        </div>
        ';

    }elseif($code == "dashboard-no-widgets-home"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4521109394024985.webp').'" />
            <h3>'.translate("tr_e052f09496f4671e700f93c6a53b6e0d").'</h3>
            <p>'.translate("tr_3223e20841238c07151e26d7601bf5ee").'</p>
            <button class="mt-4 btn btn-label-primary waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCustomizeTemplate" >'.translate("tr_d1b8c2f66dabcb50cc87beb285a63659").'</button>
        </div>
        ';            
    }elseif($code == "dashboard-no-users"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('5098379222216956.png').'" />
            <p>'.translate("tr_eb25bc736f9de4c4d6832c941e5fd76e").'</p>
        </div>
        ';            
    }elseif($code == "dashboard-no-data"){
        return '
        <div class="wrapper-alert-no-data" >

          <div class="alert alert-primary d-flex align-items-center" role="alert">
            <span class="alert-icon text-primary me-2">
              <i class="ti ti-info-circle ti-xs"></i>
            </span>
            '.translate("tr_26254ca95ba8d208a1674e9b23653d50").'
          </div>

        </div>
        ';            
    }elseif($code == "dashboard-no-data-image"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
            <h3>'.translate("tr_26254ca95ba8d208a1674e9b23653d50").'</h3>
        </div>
        ';            
    }elseif($code == "dashboard-change-section"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4521109394024985.webp').'" />
            <p>'.translate("tr_fb2183560e84158e9cc2879b51e219c1").'</p>
        </div>
        ';            
    }elseif($code == "dashboard-change-language"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4521109394024985.webp').'" />
            <p>'.translate("tr_42ed03f75e89b142f2b8b46ad6436579").'</p>
        </div>
        ';            
    }elseif($code == "dashboard-no-access-widget"){
        return '
        <div class="wrapper-alert-no-data" >

          <div class="alert alert-primary d-flex align-items-center" role="alert">
            <span class="alert-icon text-primary me-2">
              <i class="ti ti-info-circle ti-xs"></i>
            </span>
            '.translate("tr_561a7b922485b20da2c7df36a801fe01").'
          </div>

        </div>
        ';            
    }elseif($code == "dashboard-access-is-closed"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4812111112558029.webp').'" />
            <h3>'.translate("tr_d898fe8c5596b396e4a5e2459083a06a").'</h3>
            <p>'.translate("tr_b4db9c359643a68d5e0056ac910d163d").'</p>
        </div>
        ';            
    }

}