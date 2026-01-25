public function outTplPageAlias($alias=null){
    global $app;

    return '{{ outLink("'.$alias.'") }}';

}