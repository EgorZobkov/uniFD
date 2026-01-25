public function checkUpdate()
{

    $data = $this->system->uniApi("check-update");
    return json_answer($data);

}