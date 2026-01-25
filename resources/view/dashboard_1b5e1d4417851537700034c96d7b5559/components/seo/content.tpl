<form class="formSeo" >

    <div class="mb-3">
      <label class="form-label mb-2" ><?php echo translate("tr_a7a9e7a0e8845cb3afe2e7080082fe1c"); ?></label>

       <div class="seo-container-makros-list" >
         <?php echo $app->component->seo->outMacrosList($data->route_name); ?>
       </div>

    </div>

    <?php if($data->route_name == "catalog"){ ?>

    <div class="mb-3">
      <label class="form-label mb-2" ><?php echo translate("tr_8d984dfcbb94369028eb4566beb8bdc7"); ?></label>
      
      <select class="form-select selectpicker seo-catalog-change-condition-category" >
         <option value="category" ><?php echo translate("tr_605145ac6f4feac9dc9949a227e85fb8"); ?></option>
         <option value="not_category" ><?php echo translate("tr_9edd53d4ed4d8dc8ecc612221bd60055"); ?></option>
      </select>

    </div>

    <div class="seo-catalog-condition-category-container-1" >

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_68bc4bb36b8b00d197fdbb60786f7893"); ?></label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][meta_title]" class="form-control" value="<?php echo $data->content->category->meta_title; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][category][meta_desc]" ><?php echo $data->content->category->meta_desc; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h1]" class="form-control" value="<?php echo $data->content->category->h1; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h2]" class="form-control" value="<?php echo $data->content->category->h2; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h3]" class="form-control" value="<?php echo $data->content->category->h3; ?>" />
        </div>

        <div>
          <label class="form-label mb-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][category][text]" rows="6" ><?php echo $data->content->category->text; ?></textarea>
        </div>
      
    </div>

    <div class="seo-catalog-condition-category-container-2" >
      
        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_68bc4bb36b8b00d197fdbb60786f7893"); ?></label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][meta_title]" class="form-control" value="<?php echo $data->content->not_category->meta_title; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][not_category][meta_desc]" ><?php echo $data->content->not_category->meta_desc; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h1]" class="form-control" value="<?php echo $data->content->not_category->h1; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h2]" class="form-control" value="<?php echo $data->content->not_category->h2; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h3]" class="form-control" value="<?php echo $data->content->not_category->h3; ?>" />
        </div>

        <div>
          <label class="form-label mb-2" ><?php echo translate("tr_64ffe1bae8047554de614e1dc0553602"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][not_category][text]" rows="6" ><?php echo $data->content->not_category->text; ?></textarea>
        </div>

    </div>

    <?php }elseif($data->route_name == "blog"){ ?>

    <div class="mb-3">
      <label class="form-label mb-2" ><?php echo translate("tr_8d984dfcbb94369028eb4566beb8bdc7"); ?></label>
      
      <select class="form-select selectpicker seo-catalog-change-condition-category" >
         <option value="category" ><?php echo translate("tr_605145ac6f4feac9dc9949a227e85fb8"); ?></option>
         <option value="not_category" ><?php echo translate("tr_9edd53d4ed4d8dc8ecc612221bd60055"); ?></option>
      </select>

    </div>

    <div class="seo-catalog-condition-category-container-1" >

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_68bc4bb36b8b00d197fdbb60786f7893"); ?></label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][meta_title]" class="form-control" value="<?php echo $data->content->category->meta_title; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][category][meta_desc]" ><?php echo $data->content->category->meta_desc; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h1]" class="form-control" value="<?php echo $data->content->category->h1; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h2]" class="form-control" value="<?php echo $data->content->category->h2; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h3]" class="form-control" value="<?php echo $data->content->category->h3; ?>" />
        </div>

        <div>
          <label class="form-label mb-2" ><?php echo translate("tr_64ffe1bae8047554de614e1dc0553602"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][category][text]" rows="6" ><?php echo $data->content->category->text; ?></textarea>
        </div>
      
    </div>

    <div class="seo-catalog-condition-category-container-2" >
      
        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_68bc4bb36b8b00d197fdbb60786f7893"); ?></label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][meta_title]" class="form-control" value="<?php echo $data->content->not_category->meta_title; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][not_category][meta_desc]" ><?php echo $data->content->not_category->meta_desc; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h1]" class="form-control" value="<?php echo $data->content->not_category->h1; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h2]" class="form-control" value="<?php echo $data->content->not_category->h2; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h3]" class="form-control" value="<?php echo $data->content->not_category->h3; ?>" />
        </div>

        <div>
          <label class="form-label mb-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][not_category][text]" rows="6" ><?php echo $data->content->not_category->text; ?></textarea>
        </div>

    </div>

    <?php }elseif($data->route_name == "shop-catalog"){ ?>

    <div class="mb-3">
      <label class="form-label mb-2" ><?php echo translate("tr_8d984dfcbb94369028eb4566beb8bdc7"); ?></label>
      
      <select class="form-select selectpicker seo-catalog-change-condition-category" >
         <option value="category" ><?php echo translate("tr_605145ac6f4feac9dc9949a227e85fb8"); ?></option>
         <option value="not_category" ><?php echo translate("tr_9edd53d4ed4d8dc8ecc612221bd60055"); ?></option>
      </select>

    </div>

    <div class="seo-catalog-condition-category-container-1" >

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_68bc4bb36b8b00d197fdbb60786f7893"); ?></label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][meta_title]" class="form-control" value="<?php echo $data->content->category->meta_title; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][category][meta_desc]" ><?php echo $data->content->category->meta_desc; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h1]" class="form-control" value="<?php echo $data->content->category->h1; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h2]" class="form-control" value="<?php echo $data->content->category->h2; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][category][h3]" class="form-control" value="<?php echo $data->content->category->h3; ?>" />
        </div>

        <div>
          <label class="form-label mb-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][category][text]" rows="6" ><?php echo $data->content->category->text; ?></textarea>
        </div>
      
    </div>

    <div class="seo-catalog-condition-category-container-2" >
      
        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_68bc4bb36b8b00d197fdbb60786f7893"); ?></label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][meta_title]" class="form-control" value="<?php echo $data->content->not_category->meta_title; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][not_category][meta_desc]" ><?php echo $data->content->not_category->meta_desc; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h1]" class="form-control" value="<?php echo $data->content->not_category->h1; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h2]" class="form-control" value="<?php echo $data->content->not_category->h2; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][not_category][h3]" class="form-control" value="<?php echo $data->content->not_category->h3; ?>" />
        </div>

        <div>
          <label class="form-label mb-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][not_category][text]" rows="6" ><?php echo $data->content->not_category->text; ?></textarea>
        </div>

    </div>
      
    <?php }else{ ?>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_68bc4bb36b8b00d197fdbb60786f7893"); ?></label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][meta_title]" class="form-control" value="<?php echo $data->content->meta_title; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" ><?php echo translate("tr_62b685c7d7c78ac9b69b36cfc70c566f"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][meta_desc]" ><?php echo $data->content->meta_desc; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H1</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][h1]" class="form-control" value="<?php echo $data->content->h1; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H2</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][h2]" class="form-control" value="<?php echo $data->content->h2; ?>" />
        </div>

        <div class="mb-3">
          <label class="form-label mb-2" >H3</label>
          <input type="text" name="content[<?php echo $data->lang_iso; ?>][h3]" class="form-control" value="<?php echo $data->content->h3; ?>" />
        </div>

        <div>
          <label class="form-label mb-2" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?></label>
          <textarea class="form-control" name="content[<?php echo $data->lang_iso; ?>][text]" rows="6" ><?php echo $data->content->text; ?></textarea>
        </div>
      
    <?php } ?>

    <input type="hidden" name="id" value="<?php echo $data->id; ?>" >
    <input type="hidden" name="lang_iso" value="<?php echo $data->lang_iso; ?>" >

</form>        

<div class="mt-4 d-grid gap-2 col-lg-4 mx-auto">
  <button class="btn btn-primary actionSeoSaveEdit"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>