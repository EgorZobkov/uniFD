public function outBreadcrumb($data=[]){
    global $app;

    $result = '';
    $position = 2;

    $chain = $app->component->ads_categories->chainCategory($data->category_id);

    foreach ($chain->chain_array as $value) {
   
        $result .= '
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
              <a itemprop="item" href="'.$app->component->ads_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
            </li>
        ';

        $position++;
    }

    return $result;

}