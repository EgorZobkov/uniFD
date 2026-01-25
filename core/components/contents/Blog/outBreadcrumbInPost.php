public function outBreadcrumbInPost($category_id=0){
    global $app;

    $result = '';
    $position = 3;

    $chain = $app->component->blog_categories->chainCategory($category_id);

    foreach ($chain->chain_array as $value) {
   
        $result .= '
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
              <a itemprop="item" href="'.$app->component->blog_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
            </li>
        ';

        $position++;
    }

    return $result;

}