public function translite(){
    return json_answer(["result"=>slug($_POST['text'])]);
}