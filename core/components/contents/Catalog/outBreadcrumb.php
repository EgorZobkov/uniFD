public function outBreadcrumb(){
    global $app;

    $result = '';
    $position = 2;

    if($this->data->category){
        foreach ($this->data->category->chain->chain_array as $value) {
       
            $result .= '
                <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                  <a itemprop="item" href="'.$app->component->ads_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
                </li>
            ';

            $position++;
        }
    }

    if($this->data->filter_link){
        $result .= '
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><span itemprop="name">'.translateFieldReplace($this->data->filter_link, "name").'</span><meta itemprop="position" content="'.$position.'"></li>
        ';
    }

    return $result;

}