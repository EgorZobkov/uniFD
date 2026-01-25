public function deleteItemCart($id=0){
    global $app;

    if($id){
        $app->model->cart->delete("id=?", [$id]);
    }

}