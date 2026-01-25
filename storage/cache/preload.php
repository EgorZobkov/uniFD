<?php class_exists('App\Systems\View') or exit; ?>
<!doctype html>

<html lang="<?php echo $template->system->getSystemTemplate()->language; ?>" class="<?php if($template->system->getSystemTemplate()->theme_color == 'light'): echo 'light-style'; else: echo 'dark-style'; endif; ?> layout-compact layout-menu-fixed layout-navbar-fixed <?php if($template->system->getSystemTemplate()->collapsed_sidebar == true): echo 'layout-menu-collapsed'; endif; ?>" dir="<?php echo $template->system->getSystemTemplate()->direction; ?>" >
  <head>
    <meta charset="utf-8" />

    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="referrer" content="no-referrer" />
    <?php echo $template->ui->metaCsrf(); ?>
    
    <title><?php echo $title; ?></title>

    <link type="image/png" rel="shortcut icon" href="<?php echo $template->storage->name($template->settings->favicon)->get(); ?>">

    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet" type="text/css"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">

    <?php echo $template->asset->getCss('dashboard');; ?>

  </head>

  <body>

    <div class="ui-loading-screen">
      <div class="ui-loading-screen-container" >
          <div class="spinner-border text-primary" role="status">
          </div>      
      </div>
    </div>

    <div class="ui-search-screen"></div>

    <div class="layout-wrapper layout-content-navbar">

      <div class="layout-container">

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-status="visible" >
  
  <div class="app-brand demo">
    <span class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="/storage/images/1fd31581f23ff632f180db1af376d04a.webp" />
      </span>
      <span class="app-brand-text demo menu-text fw-bold">My Fandom</span>
    </span>

    <span class="layout-menu-toggle cursor-pointer menu-link text-large ms-auto">
            <i class="ti ti-circle-dot sidebar-menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle close-mobile-navbar"></i>
    </span>
  </div>

  <div class="menu-inner-list-container" >
  <ul class="menu-inner menu-inner-list">

                <li class="menu-item ">
              <a href="/dashboard_1b5e1d4417851537700034c96d7b5559" class="menu-link">
                <i class="menu-icon tf-icons ti ti-layout-grid"></i>                <div>Дашборд</div>
              </a>
            </li>
                      <li class="menu-item ">
              <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/transactions" class="menu-link">
                <i class="menu-icon ti ti-timeline"></i>                <div>Транзакции</div>
              </a>
            </li>
                      <li class="menu-item ">
              <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/deals" class="menu-link">
                <i class="menu-icon ti ti-briefcase"></i>                <div>Сделки</div>
              </a>
            </li>
          
              <li class="menu-item open">
                <a class="menu-link menu-toggle">
                  <i class="menu-icon ti ti-list-details"></i>                  <div>Маркет</div>
                </a>
                <ul class="menu-sub">

                  
                        <li class="menu-item active">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/ads" class="menu-link">
                            <div>Объявления</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/ads/categories" class="menu-link">
                            <div>Категории</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/ads/filters" class="menu-link">
                            <div>Фильтры</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/complaints" class="menu-link">
                            <div>Жалобы</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/reviews" class="menu-link">
                            <div>Отзывы</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/shops" class="menu-link">
                            <div>Магазины</div>
                          </a>
                        </li>

                        
                </ul>
              </li>
                               
             
              <li class="menu-item ">
                <a class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons ti ti-users"></i>                  <div>Пользователи</div>
                </a>
                <ul class="menu-sub">

                  
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/users" class="menu-link">
                            <div>Все</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/stories" class="menu-link">
                            <div>Сторисы</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/users/verifications" class="menu-link">
                            <div>Верификации</div>
                          </a>
                        </li>

                        
                </ul>
              </li>
                               
                         <li class="menu-item ">
              <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/chat" class="menu-link">
                <i class="menu-icon tf-icons ti ti-messages"></i>                <div>Чат</div>
              </a>
            </li>
                      <li class="menu-item ">
              <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/services" class="menu-link">
                <i class="menu-icon ti ti-brand-cashapp"></i>                <div>Услуги</div>
              </a>
            </li>
          
              <li class="menu-item ">
                <a class="menu-link menu-toggle">
                  <i class="menu-icon ti ti-article"></i>                  <div>Блог</div>
                </a>
                <ul class="menu-sub">

                  
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/blog/posts" class="menu-link">
                            <div>Посты</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/blog/categories" class="menu-link">
                            <div>Категории</div>
                          </a>
                        </li>

                        
                </ul>
              </li>
                               
                         <li class="menu-item ">
              <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/countries" class="menu-link">
                <i class="menu-icon ti ti-world"></i>                <div>Страны</div>
              </a>
            </li>
          
              <li class="menu-item ">
                <a class="menu-link menu-toggle">
                  <i class="menu-icon ti ti-settings"></i>                  <div>Системное</div>
                </a>
                <ul class="menu-sub">

                  
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/seo" class="menu-link">
                            <div>SEO</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/import-export" class="menu-link">
                            <div>Импорт/Экспорт</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/settings" class="menu-link">
                            <div>Настройки</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/translates" class="menu-link">
                            <div>Переводы</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/updates" class="menu-link">
                            <div>Обновления</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/search/keywords" class="menu-link">
                            <div>Поиск</div>
                          </a>
                        </li>

                        
                </ul>
              </li>
                               
             
              <li class="menu-item ">
                <a class="menu-link menu-toggle">
                  <i class="menu-icon ti ti-tools"></i>                  <div>Оформление</div>
                </a>
                <ul class="menu-sub">

                  
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/advertising" class="menu-link">
                            <div>Реклама</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/promo/banners" class="menu-link">
                            <div>Промо баннеры</div>
                          </a>
                        </li>

                        
                        <li class="menu-item ">
                          <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/templates" class="menu-link">
                            <div>Шаблонизатор</div>
                          </a>
                        </li>

                        
                </ul>
              </li>
                               
             
  </ul>

  </div>

</aside>

        <div class="layout-page">

          <nav class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme container-fluid" >
              
              <div class="layout-mobile-menu-toggle align-items-xl-center d-xl-none ms-3">
                <span class="nav-item nav-link open-mobile-navbar" >
                  <i class="ti ti-menu-2 ti-md"></i>
                </span>
              </div>

              <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                
                <div class="header-search-toggler-wrapper" >
                  <div class="navbar-nav align-items-center">
                    <div class="nav-item navbar-search-wrapper mb-0">
                      <span class="nav-item nav-link header-search-toggler d-flex align-items-center px-0" >
                        <i class="ti ti-search ti-md me-2 ms-3 icon-hover-color"></i>
                        <span class="d-none d-md-inline-block text-muted"><?php echo translate("tr_bfc95980634bf529e8a406db2c842b31"); ?></span>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="header-search-container" >
                  <div class="navbar-search-wrapper search-input-wrapper">
                    <input  type="text" class="form-control header-search-input border-0 ps-0 min-width-300" placeholder="<?php echo translate("tr_dbf4c0c4d4c3758ffb5fce75401b127c"); ?>" />
                    <i class="ti ti-x ti-md search-toggler header-search-toggler-close cursor-pointer"></i>
                  </div>
                  <div class="header-search-results-container" ></div>
                </div>

                <ul class="navbar-nav flex-row align-items-center ms-auto header-navbar-menu-icons">

                  <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown">
                    <span class="nav-link dropdown-toggle hide-arrow cursor-pointer pe-0 ps-0" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i class="ti ti-heart ti-md icon-hover-color"></i></span>
                    <div class="dropdown-menu dropdown-menu-end py-0 header-favorites-dropdown">
                      <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                          <h5 class="text-body mb-0 me-auto"><?php echo translate("tr_2fc413929104c1a09ae0a66c48ce0902"); ?></h5>
                        </div>
                      </div>
                      <div class="header-favorites-scrollable-container" >
                        <div class="dropdown-shortcuts-list header-favorites-container"><?php echo $template->system->getSystemFavorites(); ?></div>
                      </div>
                    </div>
                  </li>

                  <?php if($template->user->verificationAccess('view', 'dashboard-chat')->status):; ?>
                  <li class="nav-item"><a href="#" class="actionLoadCanvasChat" data-bs-toggle="offcanvas" data-bs-target="#offcanvasChat" ><i class="ti ti-messages ti-md icon-hover-color"></i> <span class="labelChatCountMessages badge-rounded-count"></span> </a></li>
                  <?php endif; ?>

                  <?php if($template->user->verificationAccess('view', 'dashboard-settings')->status):; ?>
                  <li class="nav-item"><a href="<?php echo $template->router->getRoute('dashboard-settings'); ?>" ><i class="ti ti-settings ti-md icon-hover-color"></i></a></li>
                  <?php endif; ?>

                  <li class="nav-item"><a href="<?php echo getHost(); ?>" target="_blank" ><i class="ti ti-external-link ti-md icon-hover-color"></i></a></li>

                  <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <span class="nav-link dropdown-toggle hide-arrow pe-0 ps-0" data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                        <img src="<?php echo $template->user->data->avatar_src; ?>" class="image-autofocus rounded-circle" />
                      </div>
                    </span>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="<?php echo $template->router->getRoute('dashboard-user-card', [$template->user->data->id]); ?>">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar avatar-online">
                                <img src="<?php echo $template->user->data->avatar_src; ?>" class="image-autofocus rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <span class="fw-medium d-block"><?php echo $template->user->data->short_name; ?></span>
                              <small class="text-muted"><?php echo translateField($template->user->data->role->name); ?></small>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      <li>
                        <a class="dropdown-item" href="<?php echo $template->router->getRoute('dashboard-logout'); ?>" >
                          <i class="ti ti-logout me-2 ti-sm"></i>
                          <span class="align-middle"><?php echo translate("tr_8ef2d61ae629c63b155ae66c3d2fc9fa"); ?></span>
                        </a>
                      </li>
                    </ul>
                  </li>

                </ul>
              </div>

          </nav>

          <div class="content-wrapper">
        
            

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="app-preload-body" data-params="<?php echo $template->view->getParamsPreload();; ?>" >

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3 mt-0 pt-0 pb-4 height62">
      <div class="d-flex flex-column justify-content-center">
        <div class="breadcrumbs-links-skeleton"><?php echo translate("tr_4922ea013f76c2d3622baf1f607812b6"); ?></div>
      </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-12 col-12">
            <div class="card skeleton" style="min-height: 400px;">
            </div>
        </div>

        <div class="col-lg-12 col-12">
            <div class="card skeleton" style="min-height: 600px;">
            </div>
        </div>

    </div>          

  </div>

</div>




          </div>

        </div>

      </div>

      <div class="layout-overlay layout-menu-toggle"></div>

    </div>


    <div class="content-backdrop fade"></div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCustomizeTemplate" aria-labelledby="offcanvasCustomizeTemplateLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title no-bold"><?php echo translate("tr_5af752b3d7b78f0935b58dc5d0dfc68a"); ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <hr class="mt-0 mb-0" >
      <div class="offcanvas-body mx-0 flex-grow-0">

        <form class="formCustomizeTemplate" >

          <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#offcanvasCustomizeTemplateTab1" aria-controls="offcanvasCustomizeTemplateTab1" aria-selected="true">
                <?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?>
              </button>
            </li>
            <?php if($template->user->verificationAccess('view', 'dashboard-home')->status):; ?>
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#offcanvasCustomizeTemplateTab2" aria-controls="offcanvasCustomizeTemplateTab2" aria-selected="false" tabindex="-1">
                <?php echo translate("tr_231418fb670218517f1efa529ef62044"); ?>
              </button>
            </li>
            <?php endif; ?>
          </ul>

          <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="offcanvasCustomizeTemplateTab1" role="tabpanel">

              <div><span class="bg-label-primary rounded-1 py-1 px-2"><?php echo translate("tr_0577df9ad7a2256702cd04371b2abecb"); ?></span></div>

              <div class="mt-3 w-100">
                <select name="template_language" class="form-select selectpicker" >
                  <?php $template->component->translate->outLanguagesOptions($template->system->getSystemTemplate()->language); ?>
                </select>
              </div>

              <div class="mt-4" ><span class="bg-label-primary rounded-1 py-1 px-2"><?php echo translate("tr_9e26d3c026ab4079d3967e7038b4d948"); ?></span></div>

              <div class="mt-3 w-100">
                <div class="row px-1 template-customize-styles-options">
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-icon mb-0 <?php if($template->system->getSystemTemplate()->theme_color == 'light'): echo 'checked'; endif; ?>">
                      <label class="form-check-label custom-option-content p-0" for="templateThemeColorLight">
                        <span class="custom-option-body mb-0">
                          <img src="<?php echo $template->storage->getAssetImage('light.svg'); ?>" class="img-fluid scaleX-n1-rtl">
                        </span>
                        <input name="template_theme_color" class="form-check-input d-none" type="radio" value="light" id="templateThemeColorLight" <?php if($template->system->getSystemTemplate()->theme_color == 'light'): echo 'checked="checked"'; endif; ?> >
                      </label>
                    </div>
                    <label class="form-check-label small text-nowrap"><?php echo translate("tr_cc8596f1aaba8d13e52b92bafeb63bf0"); ?></label>
                  </div>
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-icon mb-0 <?php if($template->system->getSystemTemplate()->theme_color == 'dark'): echo 'checked'; endif; ?>">
                      <label class="form-check-label custom-option-content p-0" for="templateThemeColorDark">
                        <span class="custom-option-body mb-0">
                          <img src="<?php echo $template->storage->getAssetImage('dark.svg'); ?>" class="img-fluid scaleX-n1-rtl">
                        </span>
                        <input name="template_theme_color" class="form-check-input d-none" type="radio" value="dark" id="templateThemeColorDark" <?php if($template->system->getSystemTemplate()->theme_color == 'dark'): echo 'checked="checked"'; endif; ?> >
                      </label>
                    </div>
                    <label class="form-check-label small text-nowrap"><?php echo translate("tr_02973823338195823c97bf0b6444524c"); ?></label>
                  </div>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="offcanvasCustomizeTemplateTab2" role="tabpanel">

             <ul class="list-group list-group-flush" >
                <?php echo $template->system->getSystemHomeWidgets(); ?>
             </ul>

            </div>
          </div>

          <button class="mt-4 w-100 btn btn-primary waves-effect waves-light buttonSaveOffcanvasCustomizeTemplate"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>

        </form>

      </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAuthUniId" aria-labelledby="offcanvasAuthUniIdLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title "><?php echo translate("tr_628f580197e1936f25246567e8aa80c1"); ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <hr class="mt-0 mb-0" >
      <div class="offcanvas-body my-0 mx-0 flex-grow-0">

        <div class="mt-4">

          <div class="text-center" >
            <img src="<?php echo $template->settings->uni_api_link; ?>/assets/logo/uni-id.png" height="74" class="mb-2" >
          </div>

          <form class="formAuthUniId" >

             <label class="form-label" ><?php echo translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"); ?></label>
             <input type="text" class="form-control" name="login" >

             <label class="form-label mt-2" ><?php echo translate("tr_5ebe553e01799a927b1d045924bbd4fd"); ?></label>
             <input type="password" class="form-control" name="password" >

            <button class="mt-4 w-100 btn btn-primary waves-effect waves-light actionAuthUniId"><?php echo translate("tr_63a753751e8899416d62b1d1bbb61720"); ?></button>

          </form>
          
        </div>

      </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasChat" aria-labelledby="offcanvasChatLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title "><?php echo translate("tr_378f419c63a1401d9be1d3cc87b432bc"); ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <hr class="mt-0 mb-0" >
      <div class="offcanvas-body my-0 mx-0 flex-grow-0">

        <div class="offcanvas-chat-content-dialogues" ></div> 

      </div>
    </div>

    <div class="template-customize-open-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCustomizeTemplate" ></div>

    <?php echo $template->ui->tpl("forbidden.tpl")->modal("forbidden", "small"); ?>
    <?php echo $template->ui->tpl("test-log.tpl")->modal("testLog", "medium"); ?>
    <?php echo $template->ui->tpl("load-content.tpl")->modal("loadContent", "medium"); ?>
    <?php echo $template->ui->tpl("filemanager.tpl")->modal("fileManager", "mega"); ?>
    <?php echo $template->ui->tpl("widget-notification-cron.tpl")->modal("widgetNotificationCron", "medium"); ?>

    <?php echo $template->asset->getJs('dashboard'); ?>

  </body>
</html>

