public function searchUser()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $results = "";
    $items = [];

    $find = $this->model->users->search($_POST['query'])->sort("name asc limit 100")->getAll();

    if($find){
        foreach ($find as $key => $value) {
            $results .= '<span class="container-live-search-results-item container-live-search-results-item-user" data-id="'.$value["id"].'" data-user-name="'.$value["name"].'" ><strong>'.$this->user->name($value).'</strong> ('.$value["email"].')</span>';
        }
    }else{
        $results = '<div class="container-live-search-no-results" >'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</div>';
    }

    return json_answer(["content"=>$results]);

}