public function verificationLabel($status=0){
    global $app;
    
    if($status){
        return '<span class="user-label-verification actionOpenStaticModal" data-modal-target="verificationUserInfo" ><i class="ti ti-square-rounded-check"></i></span>';
    }

}