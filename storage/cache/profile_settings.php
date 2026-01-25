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
                        <div class="header-user-dropdown-menu"> <span> <span class="mini-avatar"> <span class="mini-avatar-img">     <img class="image-autofocus" src="/storage/users/avatars/833b6ac39417bca7a091579903bf189c.webp">
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
                       <span class="user-rating-stars-count-reviews" >0 отзывов</span>
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
                        <div class="header-user-dropdown-menu"> <span> <span class="mini-avatar"> <span class="mini-avatar-img">     <img class="image-autofocus" src="/storage/users/avatars/833b6ac39417bca7a091579903bf189c.webp">
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
                       <span class="user-rating-stars-count-reviews" >0 отзывов</span>
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

      

<div class="container mt25" >

<div class="row" >

  <div class="col-md-3" >

    <div class="profile-user-sidebar d-none d-lg-block" >

    <div class="profile-user-sidebar-avatar" >
      <div>
        <div class="profile-user-sidebar-avatar-change actionChangeUserAvatar" ><i class="ti ti-camera-selfie"></i></div>
        <img class="image-autofocus" src="https://my-fd.ru/storage/users/avatars/833b6ac39417bca7a091579903bf189c.webp">
      </div>
    </div>

    <h4 class="profile-user-sidebar-full-name" >Yana Moor  </h4>

    <div class="container-user-rating-stars menu-user-rating-stars" >
        
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
               <span class="user-rating-stars-count-reviews" >0 отзывов</span>
    </div>

    <div class="profile-user-sidebar-menu" >

                      <a href="/profile"><i class="ti ti-user"></i> Профиль</a>
                                <a href="/profile/ads"><i class="ti ti-list-details"></i> Мои объявления</a>
                                <a href="/profile/orders"><i class="ti ti-truck-delivery"></i> Заказы</a>
                                <a href="/profile/chat"><i class="ti ti-message-circle"></i> Сообщения</a>
                                <a href="/profile/favorites"><i class="ti ti-heart"></i> Избранное</a>
                                <a href="/profile/reviews"><i class="ti ti-message"></i> Отзывы</a>
                
      <hr class="mt10 mb10" >

      <a href="/profile/settings"><i class="ti ti-settings"></i> Настройки</a>
      <a href="/logout"><i class="ti ti-logout"></i> Выход</a>

    </div>

</div>

  </div>

  <div class="col-md-9" >

        <h3> <strong><?php echo translate("tr_c919d65bd95698af8f15fa8133bf490d"); ?></strong> </h3>

        <div class="profile-settings-sections mt40" >
           <a href="<?php echo $template->router->getRoute('profile-settings'); ?>" class="<?php if(!$_GET['tab']){ echo 'active'; }; ?>" >
             <i class="ti ti-adjustments-horizontal"></i>
             <div><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></div>
           </a>
           <a href="<?php echo requestBuildVars(['tab'=>'payment']); ?>" class="<?php if($_GET['tab'] == 'payment'){ echo 'active'; }; ?>" >
             <i class="ti ti-credit-card"></i>
             <div><?php echo translate("tr_e3c1f39b86bb7162bddb548e2cfd6077"); ?></div>
           </a>
           <?php if($template->settings->integration_delivery_services_active):; ?>
           <a href="<?php echo requestBuildVars(['tab'=>'delivery']); ?>" class="<?php if($_GET['tab'] == 'delivery'){ echo 'active'; }; ?>" >
             <i class="ti ti-truck-delivery"></i>
             <div><?php echo translate("tr_b973ee86903271172c9b4f5529bc19bb"); ?></div>
           </a>
           <?php endif; ?>
        </div>

        <form class="profile-settings-form mt30" >

          <section class="profile-settings-section" >

            <?php if(!$_GET["tab"]):; ?>

            <h5> <strong><?php echo translate("tr_be8570cc6d6814eebc087695b7b27c31"); ?></strong> </h5>

            <div class="profile-settings-section-item d-block d-lg-none" >

              <div class="profile-user-sidebar-avatar" >
                <div>
                  <div class="profile-user-sidebar-avatar-change actionChangeUserAvatar" ><i class="ti ti-camera-selfie"></i></div>
                  <img class="image-autofocus" src="<?php echo $template->user->data->avatar_src; ?>">
                </div>
              </div>

            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_feef0975aac3bd15d35f5279ae70d0ba"); ?></label>
                 </div>
                 <div class="col-md-6" >
                  
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="user_status" value="1" id="user_status1" <?php if($template->user->data->user_status == 1):; ?> checked="" <?php endif; ?>>
                      <label class="form-check-label" for="user_status1">
                        <?php echo translate("tr_51b6f81095ef3cc7f72bf60031fd95eb"); ?>
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="user_status" value="2" id="user_status2"  <?php if($template->user->data->user_status == 2):; ?> checked="" <?php endif; ?>>
                      <label class="form-check-label" for="user_status2">
                        <?php echo translate("tr_1c5009c44310abcfe726e4e1b8f077c1"); ?>
                      </label>
                    </div>                    

                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item-organization" <?php if($template->user->data->user_status == 2):; ?> style="display: block;" <?php endif; ?> >
              
            <div class="profile-settings-section-item mb10" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_16c3e7e34102c34643e18ddc60acac86"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="organization_name" value="<?php echo $template->user->data->organization_name; ?>" >
                    <label class="form-label-error" data-name="organization_name"></label>
                 </div>
               </div>
            </div>

            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_d38d6d925c80a2267031f3f03d0a9070"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="name" value="<?php echo $template->user->data->name; ?>" >
                    <label class="form-label-error" data-name="name"></label>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_a7b7df8362d60258a7208dde0a392643"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="surname" value="<?php echo $template->user->data->surname; ?>" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <?php echo $template->ui->outInputPhoneContact($template->user->data->phone, ["input_name"=>"phone"]); ?>
                    <label class="form-label-error" data-name="phone"></label>
                    <div class="actionSendVerifyCodePhoneContainer" >
                      <span class="btn-custom-mini button-color-scheme3 actionSendVerifyCodePhone mt10" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></span>
                    </div>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="email" value="<?php echo $template->user->data->email; ?>" >
                    <label class="form-label-error" data-name="email"></label>
                    <div class="actionSendVerifyCodeEmailContainer" >
                      <span class="btn-custom-mini button-color-scheme3 actionSendVerifyCodeEmail mt10" ><?php echo translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"); ?></span>
                    </div>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_6a061313d22e51e0f25b7cd4dc065233"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="contacts[max]" value="<?php echo $template->user->data->contacts->max; ?>" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_c915683f3ec888b8edcc7b06bd1428ec"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="contacts[telegram]" value="<?php echo $template->user->data->contacts->telegram; ?>" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_8b777ebcc5034ce0fe96dd154bcb370e"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="contacts[whatsapp]" value="<?php echo $template->user->data->contacts->whatsapp; ?>" >
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_5f0ef7fba904387b273d48f4d71580f3"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <input type="text" class="form-control" name="alias" value="<?php echo $template->user->data->alias; ?>" >
                    <label class="form-label-error" data-name="alias"></label>
                    <div class="mt10" > <small><?php echo translate("tr_af36f41f9ec895e63ba31441add70ae0"); ?></small> </div>
                 </div>
               </div>
            </div>

          </section>

          <section class="profile-settings-section" >

            <h5> <strong><?php echo translate("tr_c812c9e8d05c151e233ca2560a4199b6"); ?></strong> </h5>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_207a9b18465e35d751d48b4405b6722c"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="notifications_method" value="email" id="notifications_method_email" <?php if($template->user->data->notifications_method == "email"):; ?> checked="" <?php endif; ?> >
                      <label class="form-check-label" for="notifications_method_email">
                        <?php echo translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"); ?>
                      </label>
                    </div>

                    <?php if($template->settings->profile_notifications_messenger_status):; ?>

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="notifications_method" value="telegram" id="notifications_method_telegram" <?php if($template->user->data->notifications_method == "telegram"):; ?> checked="" <?php endif; ?> >
                      <label class="form-check-label" for="notifications_method_telegram">
                        <?php echo translate("tr_c915683f3ec888b8edcc7b06bd1428ec"); ?>
                      </label>
                    </div>

                    <?php if(!$template->user->data->messenger_token_id):; ?>
                    <div class="profile-settings-section-notifications-method-telegram" <?php if($template->user->data->notifications_method == "telegram"):; ?> style="display: block;" <?php endif; ?> >
                      <a class="btn-custom-mini button-color-scheme3 mt15" href="<?php echo outUserLinkTelegramBot($template->user->data->uniq_hash); ?>" target="_blank" ><?php echo translate("tr_539327ce0420a5d3732b9f926abc1cb3"); ?></a>
                      <div class="mt10"> <small><?php echo translate("tr_2cef0f08cd8777fcc23e8f09f0c439fa"); ?></small> </div>
                    </div>
                    <?php endif; ?>

                    <?php endif; ?>

                 </div>
               </div>
            </div>

          </section>

          <section class="profile-settings-section" >

            <h5> <strong><?php echo translate("tr_d2ed721d0c08f9f114598a084f24c784"); ?></strong> </h5>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_7e264844e4fc7ea0a5ea239f44bc9736"); ?></label>
                 </div>
                 <div class="col-md-6" >
                  
                    <label class="switch mt10">
                      <input type="checkbox" class="switch-input" name="notifications[chat]" value="1" <?php if($template->user->data->notifications['chat']):; ?> checked="" <?php endif; ?> >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                    </label>

                    <div class="mt10" > <small><?php echo translate("tr_fa5bc234f95aec53134e69a6cd8d2c6e"); ?></small> </div>

                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"); ?></label>
                 </div>
                 <div class="col-md-6" >
                  
                    <label class="switch mt10">
                      <input type="checkbox" class="switch-input" name="notifications[expiration_ads]" value="1" <?php if($template->user->data->notifications['expiration_ads']):; ?> checked="" <?php endif; ?> >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                    </label>

                    <div class="mt10" > <small><?php echo translate("tr_200213b3d817a409f52ae54aa976ba71"); ?></small> </div>

                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_c1019eb5872cd3edd615a45bf988c46a"); ?></label>
                 </div>
                 <div class="col-md-6" >
                  
                    <label class="switch mt10">
                      <input type="checkbox" class="switch-input" name="notifications[expiration_tariff]" value="1" <?php if($template->user->data->notifications['expiration_tariff']):; ?> checked="" <?php endif; ?> >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                    </label>

                    <div class="mt10" > <small><?php echo translate("tr_584431a939bff261046d0d24726dfa94"); ?></small> </div>

                 </div>
               </div>
            </div>

          </section>

          <section class="profile-settings-section" >

            <h5> <strong><?php echo translate("tr_3677ee79e51454e8da26eb578c6c4e5c"); ?></strong> </h5>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_5ebe553e01799a927b1d045924bbd4fd"); ?></label>
                 </div>
                 <div class="col-md-6" >
                    <span class="btn-custom-mini button-color-scheme2 actionOpenStaticModal" data-modal-target="profileChangePassword" ><?php echo translate("tr_47e2436e5560837160a70c64466ea22b"); ?></span>
                 </div>
               </div>
            </div>

            <div class="profile-settings-section-item" >
               <span class="btn-custom-mini button-color-scheme6 actionSettingsDeleteProfile" ><?php echo translate("tr_05c7740165c17bf42aa8dcfcfaea4f56"); ?></span>
               <div class="mt10" ><small><?php echo translate("tr_6f1d1801e7fd50410971cb5c1107225f"); ?></small></div>
            </div>
            
          </section>

          <div class="row mt40 mb20" >
            <div class="col-md-4" ></div>
            <div class="col-md-4"  ><button class="btn-custom button-color-scheme1 width100 actionSettingsSaveEditProfile" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button></div>
            <div class="col-md-4" ></div>
          </div>

          <?php elseif($_GET["tab"] == "payment"):; ?>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_2f5c1b9ee6a5e20a9ccb24e72ff9796a"); ?></label>
                 </div>
                 <div class="col-md-6" >
                  
                  <?php echo $template->component->profile->outUserScoreList($template->user->data->id); ?>

                  <?php echo $template->component->profile->outMethodAddScoreUser($template->user->data->id); ?>

                  <div class="mt10" > <small><?php echo translate("tr_96b91c96f904e8bbae6dd55fa738933d"); ?></small> </div>

                 </div>
               </div>
            </div>

          <?php elseif($_GET["tab"] == "delivery" && $template->settings->integration_delivery_services_active):; ?>

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_b973ee86903271172c9b4f5529bc19bb"); ?></label>
                 </div>
                 <div class="col-md-6" >
                  
                  <label class="switch mt10">
                    <input type="checkbox" class="switch-input" name="delivery_status" value="1" <?php if($template->user->data->delivery_status):; ?> checked="" <?php endif; ?> >
                    <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                    </span>
                  </label>

                  <div class="mt10" > <small><?php echo translate("tr_3f12c278727d86f71e49583e76c9da9d"); ?></small> </div>

                 </div>
               </div>
            </div>          

            <div class="profile-settings-section-item" >
               <div class="row" >
                 <div class="col-md-3" >
                   <label><?php echo translate("tr_2e61bbda910e51ea5e79946e41788428"); ?></label>
                 </div>
                 <div class="col-md-6" >
                  
                  <?php echo $template->component->delivery->outDeliveryListInProfile(); ?>

                  <div class="profile-settings-shipping-points-list" >
                    <?php echo $template->component->profile->outShippingPointsList(); ?>
                  </div>

                  <div class="mt10" > <small><?php echo translate("tr_ce5032ca9d4153b51cf80c5ae721d861"); ?></small> </div>

                 </div>
               </div>
            </div>

          <?php endif; ?>

        </form>

  </div>

</div>

</div>

<?php echo $template->ui->tpl('modals/profile-add-payment-score-modal.tpl')->modal("addPaymentScore", "small"); ?>



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

<section class="js-auth-status" style="display:none;" data-status="true" ></section>