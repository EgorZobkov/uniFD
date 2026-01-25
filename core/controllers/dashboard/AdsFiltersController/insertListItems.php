public function insertListItems(){

    $result = '';

    if(trim($_POST["list"])){

        $list = explode("\n", trim($_POST["list"]));

        foreach (array_slice($list, 0, 1000) as $key => $value) {
            
            if(trim($value)){
                $result .= '<div class="block-filter-item"><div class="input-group"><span class="input-group-text"><div class="handle-sorting handle-sorting-move"><i class="ti ti-arrows-sort"></i></div></span><input type="text" class="form-control" name="items[add][]" value="'.trimStr($value, 128).'" ><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemFilter"><i class="ti ti-trash"></i></span></div></div>';
            }

        }

    }

    return json_answer(["status"=>true, "content"=>$result]);

}