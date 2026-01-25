public function modalOpen()
{   

     $params = [];

     if($_POST['params']){
        if(is_array($_POST['params'])){
            $params = $_POST['params'];
        }else{
            $params = _json_decode(urldecode($_POST['params']));
        }
     }

     $content = $this->ui->managerModal($_POST['target'], $params);

     if($content){
         return json_answer(["status"=>true, "content"=>$content]);
     }else{
         return json_answer(["status"=>false, "content"=>""]);
     }

}