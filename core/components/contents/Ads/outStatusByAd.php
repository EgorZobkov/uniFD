public function outStatusByAd($status=0){
    global $app;

    return '<div><span class="status-label status-label-color-'.$this->status($status)->label.'" >'.$this->status($status)->name.'</span></div>';

}