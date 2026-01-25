public function compileCore()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $result = $this->builder->compileCore();

    return dd($result);

}