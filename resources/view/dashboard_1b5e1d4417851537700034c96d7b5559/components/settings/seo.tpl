
<div class="sticky-wrapper-container" >

<div class="sticky-wrapper-actions">
  <button class="btn btn-primary waves-effect waves-light buttonSaveSettings" data-route-name="dashboard-settings-seo-save" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<div class="card mb-4">

<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_000fecfcd9ed8119c3841ca87d49d291"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0">

      <div class="row" >
        <div class="col-12 col-md-6" >
          <label class="switch">
            <input type="checkbox" name="seo_robots_manual" value="1" class="switch-input" <?php if($app->settings->seo_robots_manual){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_c099dced0d163b6e5613808eed4c3d77"); ?></span>
          </label>          
        </div>
      </div>

    </div>

    <div class="settings-seo-robots-index-container" <?php if(!$app->settings->seo_robots_manual){ echo 'style="display: block"'; } ?> >

    <div class="col-12 mt-3">

      <div class="row" >
        <div class="col-12 col-md-6" >
          <label class="switch">
            <input type="checkbox" name="seo_robots_index_status" value="1" class="switch-input" <?php if($app->settings->seo_robots_index_status){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_adac93ea7317f5a2600bc88cbfa9c1aa"); ?></span>
          </label>          
        </div>
      </div>

    </div>

    </div>

    <div class="settings-seo-robots-text-container" <?php if($app->settings->seo_robots_manual){ echo 'style="display: block"'; } ?> >

    <div class="col-12 mt-3">

      <label class="form-label mb-2" ><?php echo translate("tr_aac3200fccb1d81b323ea685675a8a15"); ?></label>

      <div class="row" >
        <div class="col-12 col-md-6" >
            <textarea class="form-control" rows="4" name="seo_robots_data" ><?php echo $app->settings->seo_robots_data; ?></textarea>          
        </div>
      </div>

    </div>

    </div>

  </div>

</div>
</div>

<div class="card mb-4">
<div class="card-header">
  <h3 class="card-title m-0"><?php echo translate("tr_5813ce0ec7196c492c97596718f71969"); ?></h3>
</div>
<div class="card-body">

  <div class="row">

    <div class="col-12 mt-0">

      <label class="form-label mb-2" ><?php echo translate("tr_45f4a328c8f8f3b0ee7c507357891b51"); ?></label>

      <div class="row mb-2" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="cities" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"cities")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_abec4531d20a8edf6717a408b1d5f340"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="row mb-2" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="ads_categories" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"ads_categories")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_ce705242992c8b9ae021a395f0f14e53"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="row mb-2" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="ads" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"ads")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_46329557da27c8e3e7a48e8e77109f88"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="row mb-2" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="link_filters" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"link_filters")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_dde44fa4446610dd00d07c25ce84aada"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="row mb-2" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="blog_posts" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"blog_posts")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_40479311ccd23f5d64eb927684429cbb"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="row mb-2" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="blog_categories" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"blog_categories")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_dce4e8c76f5f50be43b2196677026f57"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="row mb-2" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="pages" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"pages")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_82d0b36d5cb5524282c3c4fb72e74504"); ?></span>
          </label>
          
        </div>
      </div>

      <div class="row" >
        <div class="col-12 col-md-6" >

          <label class="switch">
            <input type="checkbox" name="seo_sitemap_output[]" value="shops" class="switch-input" <?php if(compareValues($app->settings->seo_sitemap_output,"shops")){ echo 'checked=""'; } ?> >
            <span class="switch-toggle-slider">
              <span class="switch-on"></span>
              <span class="switch-off"></span>
            </span>
            <span class="switch-label"><?php echo translate("tr_a2e604a203f80ee2947b9f39dbf0baac"); ?></span>
          </label>
          
        </div>
      </div>

    </div>

  </div>

</div>
</div>

</div>
