public function uploadAttach()
{   

    $result = $this->component->stories->uploadAttach($_FILES["attach_files"]);
    return json_answer($result);
 
}