public function buildXml($data=[], $feed=[]){
    global $app;

    $result = '';

    if($feed->feed_format == "yandex_yml"){

        $result = '<yml_catalog date="'.$app->datetime->format("Y-m-d H:i")->getDate().'">';
        $result .= '<shop>';

        $result .= '<url>'.getHost().'</url>';
        $result .= '<name>'.$feed->shop_title.'</name>';
        $result .= '<company>'.$feed->shop_company_name.'</company>';
        $result .= '<phone>'.$feed->shop_contact_phone.'</phone>';

        $result .= '<currencies>';
        $result .= '<currency id="'.$app->settings->system_default_currency.'" rate="1"/>';
        $result .= '</currencies>';

        $result .= '<categories>';

        $categories = $app->model->ads_categories->getAll("status=?", [1]);
        if($categories){

            foreach ($categories as $key => $value) {
                if($value["parent_id"]){
                    $result .= '<category id="'.$value["id"].'" parentId="'.$value["parent_id"].'" >'.addslashes(str_replace("&","-",$value["name"])).'</category>';
                }else{
                    $result .= '<category id="'.$value["id"].'" >'.addslashes(str_replace("&","-",$value["name"])).'</category>';
                }
            }

        }

        $result .= '</categories>';

        $result .= '<offers>';

        foreach ($data as $key => $value) {

            $value = $app->component->ads->getDataByValue($value);

            if($feed->utm_data){
                $url = $app->component->ads->buildAliasesAdCard($value) . '?' . $feed->utm_data;
            }else{
                $url = $app->component->ads->buildAliasesAdCard($value);
            }
            
            $result .= '
                <offer id="'.$value->id.'" available="true">
                <name>'.$value->title.'</name>
                <vendorCode>'.$value->id.'</vendorCode>
                <url>'.$url.'</url>
                <currencyId>'.$value->currency_code.'</currencyId>
                <categoryId>'.$value->category_id.'</categoryId>
                <price>'.$value->price.'</price>
            ';

            if($value->old_price){
                $result .= '
                    <oldprice>'.$value->old_price.'</oldprice>
                ';
            }

            if($value->media->images->all){
                foreach ($value->media->images->all as $link) {
                   $result .= '<picture>'.$link.'</picture>';
                }
            }

            if($feed->out_filters_status){
                $property = $app->component->ads_filters->outPropertyAd($value->id, [], true);
                if($property){
                    foreach ($property as $filter_key => $filter_value) {
                        $result .= '<param name="'.$filter_key.'">'.$filter_value.'</param>';
                    }
                }
            }

            $result .= '
                <description>
                <![CDATA['.$value->text.']]>
                </description>
                </offer>
            ';


        }

        $result .= '</offers>';

        $result .= '</shop>';
        $result .= '</yml_catalog>';

    }elseif($feed->feed_format == "google_merchant"){

        $result = '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">';

        $result .= '<title>'.$feed->shop_title.'</title>';
        $result .= '<link>'.getHost().'</link>';
        $result .= '<updated>'.$app->datetime->format("Y-m-d H:i")->getDate().'</updated>';

        foreach ($data as $key => $value) {

            $value = $app->component->ads->getDataByValue($value);

            if($feed->utm_data){
                $url = $app->component->ads->buildAliasesAdCard($value) . '?' . $feed->utm_data;
            }else{
                $url = $app->component->ads->buildAliasesAdCard($value);
            }
            
            $result .= '
                <entry>
                <g:title>'.$value->title.'</g:title>
                <g:id>'.$value->id.'</g:id>
                <g:link>'.$url.'</g:link>
                <g:availability>in stock</g:availability>
                <g:google_product_category>Furniture >'.$value->category->name.'</g:google_product_category>
            ';

            if($value->old_price){
                $result .= '
                    <g:price>'.$value->old_price.' '.$value->currency_code.'</g:price>
                    <g:sale_price>'.$value->price. ' '.$value->currency_code.'</g:sale_price>
                ';                
            }else{
                $result .= '
                    <g:price>'.$value->price.' '.$value->currency_code.'</g:price>
                ';                 
            }

            if($value->media->images->all){
                foreach ($value->media->images->all as $link) {
                   $result .= '<g:image_link>'.$link.'</g:image_link>';
                }
            }

            if($feed->out_filters_status){
                $property = $app->component->ads_filters->outPropertyAd($value->id, [], true);
                if($property){

                    $result .= '<g:product_detail>';

                    foreach ($property as $filter_key => $filter_value) {
                        $result .= '
                            <g:attribute_name>'.$filter_key.'</g:attribute_name>
                            <g:attribute_value>'.$filter_value.'</g:attribute_value>
                        ';
                    }

                    $result .= '</g:product_detail>';

                }
            }

            $result .= '
                <g:description>
                <![CDATA['.$value->text.']]>
                </g:description>
                </entry>
            ';


        }

        $result .= '</feed>';

    }

    return $result;

}