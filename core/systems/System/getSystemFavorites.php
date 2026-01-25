public function getSystemFavorites(){
    global $app;

    $favorites = [];
    $result = "";

    $getFavorites = $app->model->system_favorites->sort("id desc")->getAll("user_id=?", [$app->user->data->id]);

    if($getFavorites){
        foreach ($getFavorites as $value) {
            $favorites[] = '
                <div class="dropdown-shortcuts-item col">
                  <span class="dropdown-shortcuts-item-delete template-delete-favorite" data-id="'.$value["id"].'" ><i class="ti ti-trash"></i></span>
                  <span class="dropdown-shortcuts-icon mb-1" >
                    <i class="ti '.$value["page_icon"].' fs-4" ></i>
                  </span>
                  <a href="'.$app->router->getRoute($value["route_name"]).'" class="stretched-link">'.$value["page_name"].'</a>
                </div>
            ';
        }

        $chunk = array_chunk($favorites, 2);

        foreach ($chunk as $key => $nested) {
            $result .= '<div class="row row-bordered overflow-visible g-0">';
            foreach ($nested as $key => $value) {
                $result .= $value;
            }
            $result .= '</div>';
        }

        return $result;

    }else{

        return '
          <div class="header-favorites-empty text-center">
            <i class="ti ti-heart-broken"></i>
            <p>'.translate("tr_1023b68c5302f670fbb32d3fb80febd2").'</p>
          </div>
        ';

    }


}