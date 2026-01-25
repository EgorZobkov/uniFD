public function outBreadcrumb(){
    global $app;

    $result = '';
    $position = 3;

    if($this->data->category){
        foreach ($this->data->category->chain->chain_array as $value) {
       
            $result .= '
                <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                  <a itemprop="item" href="'.$app->component->blog_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
                </li>
            ';

            $position++;
        }
    }

    return $result;

}