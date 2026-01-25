public function multiDelete($ids=0){
    global $app;

    if($ids){
        foreach ($ids as $key => $value) {
            $this->delete($value);
        }
    }

}