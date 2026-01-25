<h3 class="modal-title mb-3" > <strong><?php echo translate("tr_8121328feb04392a48af5bfd7d1138d8"); ?></strong> </h3>

<?php if($app->settings->active_countries){ ?>

<?php if($app->component->geo->statusMultiCountries()){ ?>
<div class="modal-geo-countries-list mb-3" >
    <?php echo $app->component->geo->outActiveCountries(); ?>
</div>
<?php } ?>

<form class="modal-geo-form" >

<div class="modal-geo-container" >

  <div class="modal-geo-search" >
    <input type="text" class="form-control" placeholder="<?php echo translate("tr_7c99a2e8899115ee829bfb96eb580294"); ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" value="<?php echo translateFieldReplace($app->component->geo->getChange()->data, "name"); ?>" >
    <div class="modal-geo-search-results" ></div>
  </div>

  <div class="modal-geo-container-content" >

    <?php echo $app->component->geo->outOptionsFavoritesCities(); ?>

  </div>

</div>

<input type="hidden" name="geo_alias" value="<?php echo $app->component->geo->replaceAliases((array)$app->component->geo->getChange()); ?>" >

</form>

<?php } ?>