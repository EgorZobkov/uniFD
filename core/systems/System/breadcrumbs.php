public function breadcrumbs($chain=null){
    global $app;

    $results = [];

    if(isset($chain)){ 

        foreach ($chain as $name => $link) {
            if(isset($link)){
              $results[] = '<a href="'.$link.'" >'.$name.'</a>';
            }else{
              $results[] = $name;
            } 
        }

        return implode('<span class="text-muted" > / </span>', $results);

    }

}