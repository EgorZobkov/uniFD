<?php class_exists('App\Systems\View') or exit; ?>
<!doctype html>

<html lang="<?php echo $template->translate->current->iso; ?>" >
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo $seo->meta_title; ?></title>

    <meta name="description" content="<?php echo $seo->meta_desc; ?>">
    <?php echo $template->ui->metaCsrf(); ?>

    <link type="image/png" rel="shortcut icon" href="<?php echo $template->storage->name($template->settings->favicon)->get(); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Noto+Sans+KR:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&family=Ubuntu+Sans+Mono:ital,wght@0,400..700;1,400..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <meta property="og:site_name" content="<?php echo $template->settings->project_name; ?>">
    <meta property="og:type" content="website">

    
<meta property="og:title" content="<?php echo $seo->meta_title; ?>">
<meta property="og:url" content="<?php echo $template->component->ads->buildAliasesAdCard($data); ?>">
<meta property="og:description" content="<?php echo $seo->meta_desc; ?>">
<meta property="og:image" content="<?php echo $data->media->images->first; ?>">


    <?php echo $template->asset->getCss('web'); ?>

  </head>

  <body>

    <section class="flex-wrapper" >

      <header <?php if($template->view->visible_header):; ?> class="header-visible-height d-none d-lg-block" <?php else:; ?> class="header-hidden-height d-none d-lg-block" <?php endif; ?> >
<div class="header-wow" >
   
   <div class="header-wow-top" >
        <div class="container" >
           <div class="row" >
               <div class="col-lg-2">

                  <a class="h-logo" href="<?php echo outLink();; ?>" title="<?php echo $template->settings->project_title; ?>" >
                      <img src="<?php echo $template->storage->logo(); ?>"  alt="<?php echo $template->settings->project_title; ?>">
                  </a>

               </div>
               <div class="col-lg-7">

                  <div class="header-wow-top-list" >

                    <?php echo $template->component->translate->outChangeLanguages(["align-vertical"=>"top", "align-horizontal"=>"left", "container-class"=>"header-wow-top-list-item"]); ?>

                    <a href="<?php echo outLink(); ?>" class="header-wow-top-list-item" ><?php echo translate("tr_047f5653b183292396e67f14c8750b73"); ?></a>
                    <!-- <a href="<?php echo outRoute('shops'); ?>" class="header-wow-top-list-item" ><?php echo translate("tr_cfb8af01cc910b08e8796e03cf662f5f"); ?></a> -->
                    <!-- <a href="<?php echo outLink('business-tariffs'); ?>" class="header-wow-top-list-item" ><?php echo translate("tr_0c301c86194643f93cb5e144e36698bf"); ?></a> -->
                    <!-- <a href="<?php echo outLink('secure-deals'); ?>" class="header-wow-top-list-item" ><?php echo translate("tr_1eb027fdbd155cb5c39d813737a8318f"); ?></a> -->
                    <a href="<?php echo outRoute('blog'); ?>" class="header-wow-top-list-item" ><?php echo translate("tr_103a554114af7c598a4f835ac463722e"); ?></a>

                  </div>

               </div>
               <div class="col-lg-3 text-end" >

                  <div class="header-wow-top-list-icon" >

                    <?php if($template->user->isAuth()):; ?>
                    <?php if($template->router->currentRoute->name == "profile-chat"):; ?>
                    <a class="header-wow-top-list-icon-item" href="<?php echo outRoute('profile-chat'); ?>" ><i class="ti ti-messages"></i> <span class="label-circle-count chat-icon-counter labelChatCountMessages" ></span> </a>
                    <?php else:; ?>
                    <span class="actionOpenModalChat header-wow-top-list-icon-item" ><i class="ti ti-messages"></i> <span class="label-circle-count chat-icon-counter labelChatCountMessages" ></span> </span>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if($template->settings->basket_status):; ?>
                    <a href="<?php echo outRoute('cart'); ?>" class="header-wow-top-list-icon-item" ><i class="ti ti-shopping-bag"></i> <span class="label-circle-count cart-icon-counter labelCartCountItems" ></span> </a>
                    <?php endif; ?> 

                    <?php if($template->user->isAuth()):; ?>
                    <a href="<?php echo outRoute('profile-favorites'); ?>" class="header-wow-top-list-icon-item" ><i class="ti ti-heart"></i></a>
                    <?php endif; ?> 

                    <?php if($template->user->isAuth()):; ?>
                    <div class="header-wow-top-list-profile">
                        <div class="header-user-dropdown-menu"> <span> <span class="mini-avatar"> <span class="mini-avatar-img">     <img class="image-autofocus" src="https://my-fd.ru/storage/images/no-image.png">
     </span> </span>
    </span>
    <div class="header-user-dropdown-menu-box" >
        <div class="header-user-dropdown-menu-box-link">

            <div class="container-user-rating-stars menu-user-rating-stars" >
                
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
                       <span class="user-rating-stars-count-reviews" > отзывов</span>
            </div>

            <div class="mt5" >
                                <a href="/profile"><i class="ti ti-user"></i> Профиль</a>
                                <a href="/profile/ads"><i class="ti ti-list-details"></i> Мои объявления</a>
                                <a href="/profile/orders"><i class="ti ti-truck-delivery"></i> Заказы</a>
                                <a href="/profile/chat"><i class="ti ti-message-circle"></i> Сообщения</a>
                                <a href="/profile/favorites"><i class="ti ti-heart"></i> Избранное</a>
                                <a href="/profile/reviews"><i class="ti ti-message"></i> Отзывы</a>
                            </div>

            <hr class="mt10 mb10" >

            <a href="/profile/settings"><i class="ti ti-settings"></i> Настройки</a>
            <a href="/logout"><i class="ti ti-logout"></i> Выход</a>

        </div>
    </div>
</div>
                    </div>
                    <?php else:; ?>
                    <a href="<?php echo outRoute('auth'); ?>" class="header-wow-top-list-icon-item" ><i class="ti ti-login"></i></a>
                    <?php endif; ?>                  

                  </div>
                   
               </div>
           </div>
        </div>
   </div>

   <?php if($template->view->visible_header):; ?>

   <div class="header-wow-sticky" >
       
       <div class="header-wow-sticky-container" >

        <div class="container" >
         
           <div class="row" >

               <div class="col-12" >
                   
                <div class="header-flex-box" >

                   <div class="header-flex-box-1" >

                      <div class="header-button-menu-catalog open-header-menu-catalog button-color-scheme1" >
                          <span class="header-button-menu-catalog-icon-1" > <i class="ti ti-category"></i> </span>
                          <span><?php echo translate("tr_ad51225e2ef05117a709b83a87d45440"); ?></span>
                      </div>
  
                   </div>
                   
                   <div class="header-flex-box-2" >

                      <div class="live-search-container" >
                          
                            <form class="live-search-form" method="get" action="<?php echo $template->component->catalog->currentAliases(); ?>">
                                <button class="live-search-form-icon"><i class="ti ti-search"></i></button>
                                <input type="text" name="search" class="live-search-form-input" autocomplete="off" placeholder="<?php echo translate("tr_c4e13f3e179240627dcb0ef7c41ca3d4"); ?>" value="<?php echo $_GET['search']; ?>"> 
                            </form>
                            <?php if($template->settings->active_countries):; ?>
                            <div class="live-search-container-geo">
                                <div class="live-search-container-geo-name" data-bs-target="#geoModal" data-bs-toggle="modal" ><i class="ti ti-map-pin"></i> <?php echo $template->component->geo->getChange() ? translateFieldReplace($template->component->geo->getChange()->data, "name") : translate("tr_9a73b1e5b44bee481ab175b7e327451e");; ?> <?php if($template->component->geo->countChangeOptionsCity()):; ?> <span class="circle-indicator-count" ><?php echo $template->component->geo->countChangeOptionsCity();; ?></span> <?php endif;; ?> </div>
                            </div>
                            <?php endif; ?>

                            <div class="live-search-results"></div>
                          
                      </div>

                   </div>

                   <div class="header-flex-box-3" >
                        
                        <div class="toolbar-link mr10" >
                            <a href="<?php echo outRoute('ad-create'); ?>" class="header-wow-sticky-add button-color-scheme1" > <?php echo translate("tr_6a597fed338ace644982313b3cfbead4"); ?> </a>
                        </div>

                        <?php if(!$template->user->isAuth()):; ?>
                        <?php if($template->router->currentRoute->name == "login"):; ?>
                        <div class="toolbar-link" >
                           <a class="header-wow-sticky-auth button-color-scheme2" href="<?php echo outRoute('login'); ?>" ><?php echo translate("tr_63a753751e8899416d62b1d1bbb61720"); ?></a>
                        </div>
                        <?php else:; ?>
                        <div class="toolbar-link" >
                           <button class="header-wow-sticky-auth button-color-scheme2 actionOpenStaticModal" data-modal-target="auth" ><?php echo translate("tr_63a753751e8899416d62b1d1bbb61720"); ?></button>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>

                   </div>

                   </div>

               </div>

           </div>

           <div class="big-catalog-menu-container" >
                <div class="big-catalog-menu-content" >

                    <div class="row" >
                        
                        <div class="col-md-3" >
                            <div class="big-catalog-menu-content-categories" >
                             <?php echo $template->component->ads_categories->outMainCategoriesByCatalog(); ?>
                            </div>
                        </div>

                        <div class="col-md-6" >
                             <?php echo $template->component->ads_categories->outSubCategoriesByCatalog(); ?>            
                        </div>

                        <div class="col-md-3" >

                        </div>

                    </div>

                </div>
           </div>

       </div>

       </div>

   </div>

   <?php endif; ?>

</div>
</header>

<header class="d-block d-lg-none header-visible-height" >
<div class="header-wow" >

   <div class="header-wow-top" >
        <div class="container" >
            <div class="row" >
                <div class="col-4" >
                  <a class="h-logo-mobile" href="<?php echo outLink();; ?>" title="<?php echo $template->settings->project_title; ?>" >
                      <img src="<?php echo $template->storage->logoMini(); ?>"  alt="<?php echo $template->settings->project_title; ?>">
                  </a>                    
                </div>
                <div class="col-8 text-end" >
                    
                  <div class="header-wow-top-list-icon" >

                    <a class="header-wow-top-list-icon-item" href="<?php echo outRoute('ad-create'); ?>"><i class="ti ti-plus"></i></a>

                    <?php if($template->user->isAuth()):; ?>
                    <?php if($template->router->currentRoute->name == "profile-chat"):; ?>
                    <a class="header-wow-top-list-icon-item" href="<?php echo outRoute('profile-chat'); ?>" ><i class="ti ti-messages"></i> <span class="label-circle-count chat-icon-counter labelChatCountMessages" ></span> </a>
                    <?php else:; ?>
                    <span class="actionOpenModalChat header-wow-top-list-icon-item" ><i class="ti ti-messages"></i> <span class="label-circle-count chat-icon-counter labelChatCountMessages" ></span> </span>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if($template->settings->basket_status):; ?>
                    <a href="<?php echo outRoute('cart'); ?>" class="header-wow-top-list-icon-item" ><i class="ti ti-shopping-bag"></i> <span class="label-circle-count cart-icon-counter labelCartCountItems" ></span> </a>
                    <?php endif; ?> 

                    <?php if($template->user->isAuth()):; ?>
                    <a href="<?php echo outRoute('profile-favorites'); ?>" class="header-wow-top-list-icon-item" ><i class="ti ti-heart"></i></a>
                    <?php endif; ?> 

                    <?php if($template->user->isAuth()):; ?>
                    <div class="header-wow-top-list-profile">
                        <div class="header-user-dropdown-menu"> <span> <span class="mini-avatar"> <span class="mini-avatar-img">     <img class="image-autofocus" src="https://my-fd.ru/storage/images/no-image.png">
     </span> </span>
    </span>
    <div class="header-user-dropdown-menu-box" >
        <div class="header-user-dropdown-menu-box-link">

            <div class="container-user-rating-stars menu-user-rating-stars" >
                
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
                       <span class="user-rating-stars-count-reviews" > отзывов</span>
            </div>

            <div class="mt5" >
                                <a href="/profile"><i class="ti ti-user"></i> Профиль</a>
                                <a href="/profile/ads"><i class="ti ti-list-details"></i> Мои объявления</a>
                                <a href="/profile/orders"><i class="ti ti-truck-delivery"></i> Заказы</a>
                                <a href="/profile/chat"><i class="ti ti-message-circle"></i> Сообщения</a>
                                <a href="/profile/favorites"><i class="ti ti-heart"></i> Избранное</a>
                                <a href="/profile/reviews"><i class="ti ti-message"></i> Отзывы</a>
                            </div>

            <hr class="mt10 mb10" >

            <a href="/profile/settings"><i class="ti ti-settings"></i> Настройки</a>
            <a href="/logout"><i class="ti ti-logout"></i> Выход</a>

        </div>
    </div>
</div>
                    </div>
                    <?php else:; ?>
                    <a href="<?php echo outRoute('auth'); ?>" class="header-wow-top-list-icon-item" ><i class="ti ti-login"></i></a>
                    <?php endif; ?>                    

                  </div>

                </div>
            </div>
        </div>
   </div>

   <div class="header-wow-sticky" >
       
       <div class="header-wow-sticky-container" >

        <div class="container" >

            <?php if($template->router->currentRoute->name != "shop-catalog" && $template->router->currentRoute->name != "shop" && $template->router->currentRoute->name != "shop-page"):; ?>
         
                <div class="header-flex-box" >

                   <div class="header-flex-box-1" >

                      <span class="header-flex-box-icon open-header-menu-mobile-catalog" ><i class="ti ti-menu-2"></i></span>
  
                   </div>
                   
                   <div class="header-flex-box-2" >

                      <div class="live-search-container" >
                          
                            <form class="live-search-form" method="get" action="<?php echo $template->component->catalog->currentAliases(); ?>">
                                <button class="live-search-form-icon"><i class="ti ti-search"></i></button>
                                <input type="text" name="search" class="live-search-form-input" autocomplete="off" placeholder="<?php echo translate("tr_c4e13f3e179240627dcb0ef7c41ca3d4"); ?>" value="<?php echo $_GET['search']; ?>"> 
                            </form>

                            <div class="live-search-results"></div>
                          
                      </div>

                   </div>

                   <div class="header-flex-box-3" >

                      <?php if($template->settings->active_countries):; ?>
                        <span class="header-flex-box-icon openModal" data-modal-id="geoModal" ><i class="ti ti-location"></i></span>
                      <?php endif; ?>

                      <?php if($template->router->currentRoute->name == "catalog"):; ?>
                        
                      <span class="header-flex-box-icon open-menu-filters-mobile" ><i class="ti ti-adjustments-horizontal"></i> <?php if($_GET["filter"]):; ?> <span class="badge badge-dot bg-danger badge-notifications"></span> <?php endif; ?></span>

                      <?php endif; ?>

                   </div>

                </div>

            <?php else:; ?>

                <div class="header-flex-box" >

                   <div class="header-flex-box-1" >

                      <span class="header-flex-box-icon open-header-menu-mobile-catalog" ><i class="ti ti-menu-2"></i></span>
  
                   </div>
                   
                   <div class="header-flex-box-2" >

                      <div class="live-search-container" >
                          
                            <form class="live-shop-search-form" method="get" action="<?php echo $template->component->shop->linkToCatalog($data->shop->alias); ?>">
                                <button class="live-search-form-icon"><i class="ti ti-search"></i></button>
                                <input type="text" name="search" class="live-search-form-input" autocomplete="off" placeholder="<?php echo translate("tr_5466fabe16a5487db24c8e71e50cf160"); ?>" value="<?php echo $_GET['search']; ?>"> 
                            </form>

                      </div>

                   </div>

                   <?php if($template->router->currentRoute->name == "shop-catalog"):; ?>
                   <div class="header-flex-box-3" >

                      <span class="header-flex-box-icon open-menu-filters-mobile" ><i class="ti ti-adjustments-horizontal"></i> <?php if($_GET["filter"]):; ?> <span class="badge badge-dot bg-danger badge-notifications"></span> <?php endif; ?> </span>

                   </div>
                   <?php endif; ?>

                </div>

            <?php endif; ?>

       </div>

       </div>

   </div>

</div>
</header>

<div class="big-catalog-menu-mobile-container" >
    <div class="big-catalog-menu-mobile-content" >

        <span class="btn-custom-mini button-color-scheme2 mb15 close-header-menu-mobile" ><?php echo translate("tr_2b0b0225a86bb67048840d3da9b899bc"); ?></span>

        <div class="mobile-menu-list-link" >
            
            <div class="mobile-menu-list-link-item" ><?php echo $template->component->translate->outChangeLanguages(["align-vertical"=>"top", "align-horizontal"=>"left"]); ?></div>
            <a href="<?php echo outLink(); ?>" class="mobile-menu-list-link-item" ><?php echo translate("tr_047f5653b183292396e67f14c8750b73"); ?></a>
            <a href="<?php echo outRoute('blog'); ?>" class="mobile-menu-list-link-item" ><?php echo translate("tr_103a554114af7c598a4f835ac463722e"); ?></a>

            <?php if($template->router->currentRoute->name == "shop-catalog" || $template->router->currentRoute->name == "shop" || $template->router->currentRoute->name == "shop-page"):; ?>

            <?php if($template->component->shop->countPages($data->shop->id)):; ?>
            <h5 class="mt20 mb20" > <strong><?php echo translate("tr_3a70ca7b21d7f395aace23ce49218819"); ?></strong> </h5>
            <?php echo $template->component->shop->outPages($data); ?>
            <?php endif; ?>

            <?php endif; ?>

        </div>

        <?php if($template->router->currentRoute->name != "shop-catalog" && $template->router->currentRoute->name != "shop" && $template->router->currentRoute->name != "shop-page"):; ?>
                <h5 class="mt30 mb10" > <strong><?php echo translate("tr_6926e02be4135897ae84b36941554684"); ?></strong> </h5>

          <div class="mobile-menu-categories" >
            <?php echo $template->component->ads_categories->outMainCategoriesMobileList(); ?>
        </div>
        <?php endif; ?>
        <div class="mobile-menu-footer-links" >
            <a href="<?php echo outLink('rules'); ?>" class="mobile-menu-footer-link" ><?php echo translate("tr_65053ca2a9f911a081ff806e7ebd9699"); ?></a>
            <a href="<?php echo outLink('privacy-policy'); ?>" class="mobile-menu-footer-link" ><?php echo translate("tr_5513903457691ab06b8c78a293889379"); ?></a>
        </div>

    </div>
</div>

<div class="header-menu-filters-mobile-container" >
    <div class="header-menu-filters-mobile-content" >

          <span class="btn-custom-mini button-color-scheme2 mb15 close-menu-filters-mobile" ><?php echo translate("tr_2b0b0225a86bb67048840d3da9b899bc"); ?></span>

          <form class="params-form live-filters-mobile params-form-sticky" >
              <?php echo $template->component->catalog->buildParamsForm($_GET, $data->category->id, false);; ?>

              <div class="params-buttons-sticky" >
                
                <button class="btn-custom button-color-scheme1 width100 actionApplyLiveFiltersMobile" ><?php echo translate("tr_130bbbc068f7a58df5d47f6587ff4b43"); ?></button>

                <?php if($_GET["filter"]):; ?>
                <button class="btn-custom button-color-scheme3 width100 mt5 actionClearLiveFilters"><?php echo translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5"); ?></button>
                <?php endif; ?>

              </div>
          </form>

    </div>
</div>

      

<div class="container mt20 mb40" >

    <nav aria-label="breadcrumb" class="mb15" >

      <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">

        <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
          <a itemprop="item" href="<?php echo outLink();; ?>">
          <span itemprop="name"><?php echo translate("tr_047f5653b183292396e67f14c8750b73"); ?></span></a>
          <meta itemprop="position" content="1">
        </li>

        <?php echo $template->component->ads->outBreadcrumb($data);; ?>

      </ol>

    </nav>

    <?php echo $template->component->ads->outStatusInCardAd($data);; ?>

    <?php echo $template->component->ads->outActiveServicesInCardAd($data);; ?>

    <?php if($data->owner):; ?>
    <div class="ad-card-info-stat" >
        <div class="ad-card-info-stat-item actionOpenStaticModal" data-modal-target="infoAdStatUsers" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id, "view"=>"cart"]); ?>" >
            <i class="ti ti-shopping-cart-plus"></i>
            <span><?php echo $template->component->ads->getExtraStatCount($data->id)->cart; ?></span>
        </div>
        <div class="ad-card-info-stat-item actionOpenStaticModal" data-modal-target="infoAdStatUsers" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id, "view"=>"favorite"]); ?>" >
            <i class="ti ti-heart-plus"></i>
            <span><?php echo $template->component->ads->getExtraStatCount($data->id)->favorite; ?></span>
        </div>
        <div class="ad-card-info-stat-item actionOpenStaticModal" data-modal-target="infoAdStatUsers" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id, "view"=>"contacts"]); ?>" >
            <i class="ti ti-address-book"></i>
            <span><?php echo $template->component->ads->getExtraStatCount($data->id)->view_contacts; ?></span>
        </div>
    </div>
    <?php endif; ?>

    <div class="row" >

      <div class="col-md-9" >

        <h1 class="font-bold text-break-word" ><?php echo $seo->h1;; ?></h1>

        <div class="ad-card-info-line" >
          <span><?php echo $template->datetime->outLastTime($data->time_create);; ?></span>
          <span><i class="ti ti-eye"></i> <?php echo $template->component->ads->getViews($data->id);; ?> (<?php echo $template->component->ads->getViewsToday($data->id);; ?> <?php echo translate("tr_a9705117762f35c4940a622bc9940a01"); ?>)</span>
          <span>№<?php echo $data->article_number;; ?></span>
        </div>

      </div>

      <div class="col-md-3 text-end" >

        <?php if($data->owner):; ?>
        <div class="ad-card-menu-line" >
          <span class="ad-card-menu-line-item active-scale actionOpenStaticModal" data-modal-target="adShare" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><i class="ti ti-share-3"></i></span>
        </div>
        <?php else:; ?>
        <div class="ad-card-menu-line" >

          <?php if($template->user->isAuth()):; ?>
          <span class="action-to-favorite actionManageFavorite ad-card-menu-line-item active-scale" data-id="<?php echo $data->id;; ?>" > <?php if($data->in_favorites):; ?> <i class="ti ti-heart-filled"></i> <?php else:; ?> <i class="ti ti-heart"></i> <?php endif; ?> </span>
          <span class="ad-card-menu-line-item active-scale actionOpenStaticModal" data-modal-target="adShare" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><i class="ti ti-share-3"></i></span>
          <span class="ad-card-menu-line-item" > 
            
            <div class="uni-dropdown">
              <span class="uni-dropdown-name"> <i class="ti ti-dots"></i> </span>  
              <div class="uni-dropdown-content uni-dropdown-content-align-right" >
               <span class="uni-dropdown-content-item actionOpenStaticModal" data-modal-target="adComplain" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><?php echo translate("tr_a7d9ae0c14b6559b102994d3f798a934"); ?></span>
              </div>               
            </div>

          </span>
          <?php else:; ?>
          <span class="ad-card-menu-line-item active-scale actionOpenStaticModal" data-modal-target="adShare" data-modal-params="<?php echo buildAttributeParams(["id"=>$data->id]); ?>" ><i class="ti ti-share-3"></i></span>
          <?php endif; ?>

        </div>
        <?php endif; ?>

      </div>      

      <div class="col-md-12" >
          <div class="mt30" >
              <?php echo $template->component->ads->outMediaGalleryInCard($data, ["height"=>"300px"]);; ?>
          </div>        
      </div>

    </div>

    <div class="row mt20" >
      <div class="col-md-12 col-lg-9 col-12 col-sm-12 order-lg-1 order-2" >

          <div class="ad-card-content" >

            <?php if(!$data->owner):; ?>
            <div class="ad-card-content-info-box-container content-info-box-swiper" >
              
              <div class="swiper-wrapper" >

                <?php if($data->user->verification_status):; ?>
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong><?php echo translate("tr_d166070a6ff746806290ce4eb118c519"); ?></strong>
                   <p><?php echo translate("tr_84e690943a800bb844348787d3822f91"); ?></p>
                </div>
                <?php endif; ?>

                <?php if($data->booking_status && $template->component->ads_categories->categories[$data->category_id]["booking_action"] == "booking"):; ?>
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong><?php echo translate("tr_e01455d6488a28892a1e696ff34b2588"); ?></strong>
                   <p><?php echo translate("tr_8008b2f2e6f1541bfe6eb7a9780b1f16"); ?></p>
                </div>
                <?php endif; ?>

                <?php if($data->online_view_status):; ?>
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong><?php echo translate("tr_b25662e0ea7b58a615d25d1dbd762766"); ?></strong>
                   <p><?php echo translate("tr_13ff02489fc934fa9638a0ffa1d354d5"); ?></p>
                </div>
                <?php endif; ?>

                <?php if($data->delivery_status == 1 && $data->user->delivery_status):; ?>
                <div class="ad-card-content-info-box swiper-slide" >
                   <strong><?php echo translate("tr_c62d9a9729db83c1d8f2de72211c2111"); ?></strong>
                   <p><?php echo translate("tr_b90bbcd6e88c43efe24b8bbf512dd596"); ?></p>
                </div>
                <?php endif; ?>

              </div>

            </div>
            <?php endif; ?>

            <?php if($data->geo):; ?>
            <div class="ad-card-content-item" >
              <p class="ad-card-subtitle" ><?php echo translate("tr_9a2f0ded92075434b49c94329297a21c"); ?></p>

              <div><?php echo $template->component->ads->outGeoAndAddressInAdCard($data); ?></div>
              
              <?php echo $template->component->ads->outGeoMetroInAdCard($data); ?>

              <?php if($data->address_latitude && $data->address_longitude):; ?>
              <div><button class="btn-custom button-color-scheme2 mt15 actionAdShowMap"><?php echo translate("tr_8b766767c5f658ee12f29aba7145955f"); ?></button></div>
              <div class="ad-card-content-geo-map initMapAddress" id="initMapAddress" ><?php echo $template->component->geo->outMapPointAddressInAdCard($data->address_latitude, $data->address_longitude); ?></div>
              <?php endif; ?>

            </div>
            <?php endif; ?>
            
            <div class="ad-card-content-item" >
              <p class="ad-card-subtitle" ><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></p>

              <p class="text-break-word" ><?php echo outTextWithLinks($seo->text);; ?></p>
            </div>

            <?php if($data->property):; ?>

            <div class="ad-card-content-item" >
              <p class="ad-card-subtitle" ><?php echo translate("tr_d6f9a39be4b8938d8499ac3b525abea7"); ?></p>

              <div class="ad-card-list-properties">
                <?php echo $data->property; ?>
              </div>

            </div>

            <?php endif; ?>

          </div>

          <div class="ad-card-reviews-content" >
            
              <div class="my-tabs-items-big" >
                  <div data-id="1" class="my-tabs-item active" ><?php echo translate("tr_1c3fea01a64e56bd70c233491dd537aa"); ?> <span><?php echo $data->count_reviews; ?></span> </div>
              </div>

              <div class="my-tabs-content-container" >

                <div class="my-tabs-content-1" >
                  
                  <div class="container-reviews-list" >

                    <?php if($data->count_reviews):; ?>

                    <?php echo $template->component->reviews->outAllMediaByItemId($data); ?>
                      
                    <?php echo $template->component->reviews->outReviewsByItemId($data); ?>

                    <?php else:; ?>

                    <p><?php echo translate("tr_4dda1a9f6d2523f65f37d0677839cadd"); ?></p>

                    <?php endif; ?>
                    
                  </div>                  

                </div>

              </div>

          </div>


      </div>
      <div class="col-lg-3 col-md-12 col-12 col-lg-2 order-1 mb20" >
          
          <?php if($data->booking_status && !$data->owner):; ?>
          <div class="mb15" >

            <div class="ad-card-booking-calendar" data-id="<?php echo $data->id; ?>" >
              <div class="ad-card-booking-calendar-range1" style="display: none;" ></div>
              <div class="ad-card-booking-calendar-range2"></div>
            </div>

            <div class="ad-card-booking-calendar-button-order" >
              <span class="btn-custom button-color-scheme7 width100 mt20 mb10" ><?php echo translate("tr_8451e9509832d0c5d778ea3333902b06"); ?></span>
            </div>

          </div>
          <?php endif; ?>

          <div class="ad-card-sidebar" >

              <div class="ad-card-prices" >

                <?php echo $template->component->ads->outPrices($data); ?>

                <?php echo $template->component->ads->outPriceDifferentCurrenciesInAdCard($data); ?>

              </div>

              <div class="ad-card-action-buttons" >
                <?php echo $template->component->ads->outActionButtonsInAdCard($data); ?>
              </div>

              <div class="ad-card-user" >
                
                <div class="ad-card-user-avatar" >
                  
                    <div>
                      <img class="image-autofocus" src="<?php echo $data->user->shop ? $template->storage->name($data->user->shop->image)->get() : $data->user->avatar_src; ?>">
                    </div>

                </div>

                <div class="ad-card-user-content" >

                    <?php if($data->user->shop):; ?>
                    <a href="<?php echo $template->component->shop->linkToShopCard($data->user->shop->alias); ?>"><?php echo $data->user->shop->title; ?> <?php echo $template->component->profile->verificationLabel($data->user->verification_status); ?> </a>
                    <?php else:; ?>
                    <a href="<?php echo $template->component->profile->linkUserCard($data->user->alias); ?>"><?php echo $data->user->full_name; ?> <?php echo $template->component->profile->verificationLabel($data->user->verification_status); ?> </a>
                    <?php endif; ?>

                    <div class="container-user-rating-stars menu-user-rating-stars" >
                        <?php echo $template->component->profile->outStarsRating($data->user->total_rating); ?>
                        <span class="user-rating-stars-count-reviews" ><?php echo $template->component->profile->outTotalReviews($data->user->total_reviews); ?></span>
                    </div>

                </div>

              </div>

          </div>

          <?php echo $template->component->ads->outActionButtonsOrderAdCard($data); ?>

      </div>

    </div>

    <?php if($data->similar_items):; ?>
    <div class="row mt40" >
      <div class="col-md-12" >

          <div class="ad-card-similar-content" >

              <?php if($data->user->service_tariff->items->hiding_competitors_ads):; ?>

                <h1 class="font-bold" ><?php echo translate("tr_f6f59e47a711dada3fd8aa7bc2d393ef"); ?></h1>

              <?php else:; ?>

                <h1 class="font-bold" ><?php echo translate("tr_ac1eb1af525b79b5645d1fad58c4612d"); ?></h1>

              <?php endif; ?>

              <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 mt40" >
                <?php echo $data->similar_items; ?>
              </div>

          </div>

      </div>

    </div>
    <?php endif; ?>

</div>

<?php echo $template->ui->tpl('modals/contact-modal.tpl')->modal("contact", "small"); ?>



    </section>

    <?php if($template->view->visible_footer):; ?>

<footer>
<div class="footer-bg" >
    <div class="container" >

        <?php if($template->settings->api_app_section_download_status):; ?>
        <section class="section-promo-download-app">
          
          <div class="row">
             <div class="col-lg-7">
                
                <h2> <span class="color-title-accent-white"><?php echo translate("tr_66dbee51023e520794f125d4d842abbb"); ?> </span> <br> <strong><?php echo $template->settings->api_app_project_name; ?></strong> </h2>

                <p><?php echo translate("tr_60e0bd863451c402d1f35395c4330b10"); ?></p>

             </div>
          </div>

          <div class="mt20" style="position: relative; z-index: 2;">
             
             <?php if($template->settings->api_app_download_only_apk):; ?>
             <a href="<?php echo $template->settings->api_app_download_link_apk; ?>" class="btn-custom button-color-scheme2"><?php echo translate("tr_2b217944b57b8ace46974d4fea5c1f98"); ?></a>
             <?php else:; ?>

                <?php if($template->settings->api_app_download_links["play_market"]):; ?>
                <a href="<?php echo $template->settings->api_app_download_links["play_market"]; ?>" class="btn-custom button-color-scheme2 mr5">Play Market</a>
                <?php endif;; ?>

                <?php if($template->settings->api_app_download_links["app_store"]):; ?>
                <a href="<?php echo $template->settings->api_app_download_links["app_store"]; ?>" class="btn-custom button-color-scheme2 mr5">App Store</a>
                <?php endif;; ?>

                <?php if($template->settings->api_app_download_links["app_gallery"]):; ?>
                <a href="<?php echo $template->settings->api_app_download_links["app_gallery"]; ?>" class="btn-custom button-color-scheme2 mr5">AppGallery</a>
                <?php endif;; ?>

                <?php if($template->settings->api_app_download_links["ru_store"]):; ?>
                <a href="<?php echo $template->settings->api_app_download_links["ru_store"]; ?>" class="btn-custom button-color-scheme2">RuStore</a>
                <?php endif;; ?>

             <?php endif;; ?>

          </div>

          <img src="<?php echo $template->storage->getAssetImage("smart-app-photo-22215462343.png"); ?>" class="section-promo-download-app-image-device" height="460">

        </section>
        <?php endif;; ?>

        <div class="footer-bg-box-link-inline" >
            
            <!--<a href="<?php echo outRoute('shops'); ?>" class="footer-bg-box-link-inline-item" ><?php echo translate("tr_cfb8af01cc910b08e8796e03cf662f5f"); ?></a>-->
            <a href="<?php echo outRoute('blog'); ?>" class="footer-bg-box-link-inline-item" ><?php echo translate("tr_103a554114af7c598a4f835ac463722e"); ?></a>
            <a href="<?php echo outLink('about'); ?>" class="footer-bg-box-link-inline-item" ><?php echo translate("tr_4d4b965543303cec8425b75a4a839242"); ?></a>
            <a href="<?php echo outLink('support'); ?>" class="footer-bg-box-link-inline-item" ><?php echo translate("tr_64425f291098b47b020295a65b376177"); ?></a>

        </div>  

        <div class="row mt30" >

             <div class="col-md-8" >

                <p class="footer-content-text" >
                  © <?php echo date("Y"); ?> <?php echo $template->settings->project_title;; ?>
                  <br>
                  <?php echo $template->settings->contact_organization_name;; ?>
                </p>
              
                <div class="footer-content-link-inline" >
                  <a href="<?php echo outLink('rules'); ?>"><?php echo translate("tr_65053ca2a9f911a081ff806e7ebd9699"); ?></a>
                  <a href="<?php echo outLink('privacy-policy'); ?>"><?php echo translate("tr_5513903457691ab06b8c78a293889379"); ?></a>
                </div>
                 
             </div>

             <div class="col-md-4" >

                 <?php if($template->ui->outContactSocialLinks()):; ?>

                 <div class="footer-social-links" >

                    <?php echo $template->ui->outContactSocialLinks();; ?>

                 </div>

                 <?php endif;; ?>

             </div>

        </div>
        
    </div>
</div>
</footer>
<?php endif;; ?>

<?php if($template->router->currentRoute->name != "shop-catalog" && $template->router->currentRoute->name != "shop" && $template->router->currentRoute->name != "shop-page" && $template->router->currentRoute->name != "search-by-map"):; ?>

<div class="main-floating-menu d-block d-lg-none" >

    <a href="<?php echo outRoute('/'); ?>">
        <div>
            <span> <i class="ti ti-home"></i> </span>
            <span><?php echo translate("tr_3343f5fb00e4115fa416881e7d3f48dc"); ?></span>
        </div>
    </a>

    <a href="<?php echo outRoute('profile-favorites'); ?>">
        <div>
            <span> <i class="ti ti-heart"></i> </span>
            <span><?php echo translate("tr_2fc413929104c1a09ae0a66c48ce0902"); ?></span>
        </div>
    </a>

    <a href="<?php echo outRoute('ad-create'); ?>">
        <div>
            <span> <i class="ti ti-plus"></i> </span>
            <span><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span>
        </div>
    </a>

    <a href="#" class="actionOpenModalChat" >
        <div>
            <span> <i class="ti ti-brand-line"></i> </span>
            <span><?php echo translate("tr_c52b4c5cbc879d56c633f568acfbf205"); ?> <span class="label-circle-count chat-icon-counter labelChatCountMessages" ></span> </span>
        </div>
    </a>

    <a href="<?php echo outRoute('profile'); ?>">
        <div>
            <span> <i class="ti ti-mood-tongue-wink"></i> </span>
            <span><?php echo translate("tr_a46c372347e02010f5ef45fe441e4349"); ?></span>
        </div>
    </a>

</div>

<?php endif;; ?>

<div class="footer-cookie-container" >
    <div>
        <h6> <strong><?php echo translate("tr_f9bee2e2665098394863732ab76d7798"); ?></strong> </h6>
        <p><?php echo translate("tr_db44a56d204b8cc138511293df30f1f6"); ?></p>
        <span class="btn-custom-mini button-color-scheme1 actionCookieHide" ><?php echo translate("tr_55677a568e9c2b3c6a55545a1e9b8800"); ?></span>
    </div>
</div>

    <?php echo $template->asset->getJs('web'); ?>

    <noindex>

    <?php echo $template->ui->tpl('modals/geo-modal.tpl')->modal("geo", "big"); ?>
    <?php echo $template->ui->tpl('profile/chat/modal.tpl')->modal("chat", "big"); ?>
    <?php echo $template->ui->tpl('modals/payment-modal.tpl')->modal("payment", "medium"); ?>

    <?php echo htmlspecialchars_decode($template->settings->frontend_scripts); ?>

    </noindex>

  </body>
</html>



<section class="js-auth-status" style="display:none;" data-status="false" ></section>