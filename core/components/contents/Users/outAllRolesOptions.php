public function outAllRolesOptions($role_id=null){
    global $app;

    $result = '';

    $getRoles = $app->model->system_roles->sort("id asc")->getAll();
    if($getRoles){
      foreach ($getRoles as $key => $role) {
        if(isset($role_id)){
            if($role_id == $role["id"]){
                $result .= '<option value="'.$role["id"].'" data-chief="'.$role["chief"].'" selected="" >'. translateField($role["name"]).'</option>';
            }else{
                $result .= '<option value="'.$role["id"].'" data-chief="'.$role["chief"].'" >'. translateField($role["name"]).'</option>';
            }
        }else{
            $result .= '<option value="'.$role["id"].'" data-chief="'.$role["chief"].'" >'. translateField($role["name"]).'</option>';
        }
      }
    }

    return $result;

}