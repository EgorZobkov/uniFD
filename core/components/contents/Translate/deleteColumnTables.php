 public function deleteColumnTables($iso=null){
    global $app;

    if($iso){

        $app->db->deleteColumn("uni_ads_categories", "name_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "alias_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_title_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_desc_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_h1_".$iso);
        $app->db->deleteColumn("uni_ads_categories", "seo_text_".$iso);

        $app->db->deleteColumn("uni_ads_filters", "name_".$iso);
        $app->db->deleteColumn("uni_ads_filters", "alias_".$iso);

        $app->db->deleteColumn("uni_ads_filters_items", "name_".$iso);
        $app->db->deleteColumn("uni_ads_filters_items", "alias_".$iso);

        $app->db->deleteColumn("uni_ads_filters_links", "name_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_title_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_desc_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_h1_".$iso);
        $app->db->deleteColumn("uni_ads_filters_links", "seo_text_".$iso);

        $app->db->deleteColumn("uni_blog_categories", "name_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "alias_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_title_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_desc_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_h1_".$iso);
        $app->db->deleteColumn("uni_blog_categories", "seo_text_".$iso);

        $app->db->deleteColumn("uni_blog_posts", "title_".$iso);
        $app->db->deleteColumn("uni_blog_posts", "alias_".$iso);
        $app->db->deleteColumn("uni_blog_posts", "content_".$iso);
        $app->db->deleteColumn("uni_blog_posts", "seo_desc_".$iso);

        $app->db->deleteColumn("uni_promo_banners", "title_".$iso);
        $app->db->deleteColumn("uni_promo_banners", "text_".$iso);

        $app->db->deleteColumn("uni_geo_cities", "name_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "seo_text_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "region_name_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "country_name_".$iso);
        $app->db->deleteColumn("uni_geo_cities", "declension_".$iso);

        $app->db->deleteColumn("uni_geo_cities_districts", "name_".$iso);
        $app->db->deleteColumn("uni_geo_cities_metro", "name_".$iso);

        $app->db->deleteColumn("uni_geo_countries", "name_".$iso);
        $app->db->deleteColumn("uni_geo_countries", "declension_".$iso);
        $app->db->deleteColumn("uni_geo_countries", "seo_text_".$iso);

        $app->db->deleteColumn("uni_geo_regions", "name_".$iso);
        $app->db->deleteColumn("uni_geo_regions", "declension_".$iso);
        $app->db->deleteColumn("uni_geo_regions", "seo_text_".$iso);

        $app->db->deleteColumn("uni_ads_services", "name_".$iso);
        $app->db->deleteColumn("uni_ads_services", "text_".$iso);

        $app->db->deleteColumn("uni_chat_channels", "name_".$iso);
        $app->db->deleteColumn("uni_chat_channels", "text_".$iso);

        $app->db->deleteColumn("uni_users_tariffs", "name_".$iso);
        $app->db->deleteColumn("uni_users_tariffs", "text_".$iso);

        $app->db->deleteColumn("uni_users_tariffs_items", "name_".$iso);
        $app->db->deleteColumn("uni_users_tariffs_items", "text_".$iso);

        $app->db->deleteColumn("uni_search_keywords", "name_".$iso);
        $app->db->deleteColumn("uni_search_keywords", "tags_".$iso);

    }

}