public function outContentSections($iso=null, $view=null){
    global $app;

    ?>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=content'; ?>" class="nav-link <?php if($view == "content" || !$view){ echo 'active'; } ?>">
            <?php echo translate("tr_a19a091b2bf0c6a0423f2fe15671722d"); ?>
          </a>
        </li>
       
        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=js_content'; ?>" class="nav-link <?php if($view == "js_content"){ echo 'active'; } ?>">
            <?php echo translate("tr_8f8a71d6451f02bc3913403653cd8c95"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=app_content'; ?>" class="nav-link <?php if($view == "app_content"){ echo 'active'; } ?>">
            <?php echo translate("tr_f7d347aed39d6f04054946d6d3f7a271"); ?>
          </a>
        </li>

        <?php if($iso != $app->settings->default_language){ ?>
        
        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_categories'; ?>" class="nav-link <?php if($view == "ads_categories"){ echo 'active'; } ?>">
            <?php echo translate("tr_e00f391c7735dc851cfed26cbd6bbfb7"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_filters'; ?>" class="nav-link <?php if($view == "ads_filters"){ echo 'active'; } ?>">
            <?php echo translate("tr_b121cf19e04e19e70d3b978bf15f3fa7"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_filters_items'; ?>" class="nav-link <?php if($view == "ads_filters_items"){ echo 'active'; } ?>">
            <?php echo translate("tr_2a340cb64902526fa819822f2c047d6c"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_filters_links'; ?>" class="nav-link <?php if($view == "ads_filters_links"){ echo 'active'; } ?>">
            <?php echo translate("tr_dde44fa4446610dd00d07c25ce84aada"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=blog_categories'; ?>" class="nav-link <?php if($view == "blog_categories"){ echo 'active'; } ?>">
            <?php echo translate("tr_4c239493d16523d932847244c80c028a"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=blog_posts'; ?>" class="nav-link <?php if($view == "blog_posts"){ echo 'active'; } ?>">
            <?php echo translate("tr_40479311ccd23f5d64eb927684429cbb"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=promo_banners'; ?>" class="nav-link <?php if($view == "promo_banners"){ echo 'active'; } ?>">
            <?php echo translate("tr_369c5894a00530143785ee61375995ea"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=ads_services'; ?>" class="nav-link <?php if($view == "ads_services"){ echo 'active'; } ?>">
            <?php echo translate("tr_7b1c170a6d767f68a49d7e9b001047a3"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=chat_channels'; ?>" class="nav-link <?php if($view == "chat_channels"){ echo 'active'; } ?>">
            <?php echo translate("tr_1145940bfe5eafc4ef72e793bd2593f0"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=users_tariffs'; ?>" class="nav-link <?php if($view == "users_tariffs"){ echo 'active'; } ?>">
            <?php echo translate("tr_a49106cadab8ae1ff6a37e7ccea9c665"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=users_tariffs_items'; ?>" class="nav-link <?php if($view == "users_tariffs_items"){ echo 'active'; } ?>">
            <?php echo translate("tr_bb9c3b7210bf05f8336e0d074433e5c6"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=countries'; ?>" class="nav-link <?php if($view == "countries"){ echo 'active'; } ?>">
            <?php echo translate("tr_f492287bd5434c17eca5eac67c5ad4c4"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=regions'; ?>" class="nav-link <?php if($view == "regions"){ echo 'active'; } ?>">
            <?php echo translate("tr_81b8d9aded466a2ad70e6dcdd34d22a2"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=cities'; ?>" class="nav-link <?php if($view == "cities"){ echo 'active'; } ?>">
            <?php echo translate("tr_e4775a4f4afed1b72fd3a52a9545e3cf"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=cities_districts'; ?>" class="nav-link <?php if($view == "cities_districts"){ echo 'active'; } ?>">
            <?php echo translate("tr_73d7050e5b86bed85fdc6182c27b7d59"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=cities_metro'; ?>" class="nav-link <?php if($view == "cities_metro"){ echo 'active'; } ?>">
            <?php echo translate("tr_3b0b18d398bb3870f3453f78fa021ada"); ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $app->router->getRoute('dashboard-translates') . '?iso=' . $iso . '&view=search_keywords'; ?>" class="nav-link <?php if($view == "search_keywords"){ echo 'active'; } ?>">
            <?php echo translate("tr_bfc95980634bf529e8a406db2c842b31"); ?>
          </a>
        </li>

        <?php } ?>

    <?php

}