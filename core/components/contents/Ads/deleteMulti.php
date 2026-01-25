public function deleteMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $this->delete($id);

        }
    }

}