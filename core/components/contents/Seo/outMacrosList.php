public function outMacrosList($route_name=null){
    global $app;

    $macrosList = $this->macrosList();

    foreach ($macrosList["default"] as $key => $value) {
        echo '<span class="badge rounded-pill bg-primary copyToClipboard" title="'.$value.'" >'.$key.'</span>';
    }

    if($macrosList[$route_name]){
        foreach ($macrosList[$route_name] as $key => $value) {
            echo '<span class="badge rounded-pill bg-primary copyToClipboard" title="'.$value.'" >'.$key.'</span>';
        }
    }

}