public function sitemap(){

     $content = "";
     $lines = "";

     if(compareValues($this->settings->seo_sitemap_output, "cities") || compareValues($this->settings->seo_sitemap_output, "ads_categories") || compareValues($this->settings->seo_sitemap_output, "ads")){

        $ads = $this->model->ads_data->sort("id desc limit 10000")->getAll("status=?", [1]);

        if($ads){

            foreach ($ads as $value) {

                if(compareValues($this->settings->seo_sitemap_output, "cities")){

                    $city = $this->model->geo_cities->cacheKey(["id"=>$value["city_id"]])->find("id=?", [$value["city_id"]]);

                    if($city){
                        $lines .= '
                            <url>
                                <loc>'.outLink($city->alias).'</loc>
                                <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                                <priority>0.8</priority>
                            </url>
                        ';
                    }

                }

                if(compareValues($this->settings->seo_sitemap_output, "ads_categories")){

                    $lines .= '
                        <url>
                            <loc>'.$this->component->ads_categories->buildAliases(["id"=>$value["category_id"]]).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';

                }

                if(compareValues($this->settings->seo_sitemap_output, "ads")){

                    $value = $this->component->ads->getDataByValue($value);

                    $lines .= '
                        <url>
                            <loc>'.$this->component->ads->buildAliasesAdCard($value).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';

                }

            }

        }

     }

     if(compareValues($this->settings->seo_sitemap_output, "link_filters")){
        
        $filtersLinks = $this->model->ads_filters_links->sort("id desc")->getAll();

        if($filtersLinks){

            foreach ($filtersLinks as $value) {

                $lines .= '
                    <url>
                        <loc>'.$this->component->ads_filters->buildAliasesLink($value).'</loc>
                        <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                        <priority>0.8</priority>
                    </url>
                ';

            }

        }

     }

     if(compareValues($this->settings->seo_sitemap_output, "blog_posts") || compareValues($this->settings->seo_sitemap_output, "blog_categories")){
        
        $posts = $this->model->blog_posts->sort("id desc")->getAll("status=?", [1]);

        if($posts){

            foreach ($posts as $value) {

                if(compareValues($this->settings->seo_sitemap_output, "blog_posts")){

                    $lines .= '
                        <url>
                            <loc>'.$this->component->blog->buildAliasesPostCard($value).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';

                }

                if(compareValues($this->settings->seo_sitemap_output, "blog_categories")){

                    $lines .= '
                        <url>
                            <loc>'.$this->component->blog_categories->buildAliases(["id"=>$value["category_id"]]).'</loc>
                            <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                            <priority>0.8</priority>
                        </url>
                    ';                        

                }

            }

        }                

     }

     if(compareValues($this->settings->seo_sitemap_output, "pages")){
        
        $pages = $this->model->template_pages->getAll("freeze=? and alias is not null", [0]);

        if($pages){

            foreach ($pages as $value) {

                $lines .= '
                    <url>
                        <loc>'.outLink($value["alias"]).'</loc>
                        <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                        <priority>0.8</priority>
                    </url>
                ';

            }

        }

     }

     if(compareValues($this->settings->seo_sitemap_output, "shops")){
        
        $shops = $this->model->shops->getAll("status=?", [1]);

        if($shops){

            foreach ($shops as $value) {

                $lines .= '
                    <url>
                        <loc>'.$this->component->shop->linkToShopCard($value["alias"]).'</loc>
                        <lastmod>'.$this->datetime->format("Y-m-d")->getDate().'</lastmod>
                        <priority>0.8</priority>
                    </url>
                ';

            }

        }

     }

     $content = '
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
            '.$lines.'
        </urlset>
     ';

     _file_put_contents(BASE_PATH . "/sitemap.xml", $content);

}