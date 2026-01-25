public function deleteMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            if($id != $app->user->data->id){
                $this->delete($id);
            }

        }
    }

}