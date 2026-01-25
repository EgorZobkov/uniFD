<!doctype html>

<html lang="{{ $template->system->getSystemTemplate()->language }}" class="{% if($template->system->getSystemTemplate()->theme_color == 'light'): echo 'light-style'; else: echo 'dark-style'; endif %} layout-compact layout-menu-fixed layout-navbar-fixed {% if($template->system->getSystemTemplate()->collapsed_sidebar == true): echo 'layout-menu-collapsed'; endif %}" dir="{{ $template->system->getSystemTemplate()->direction }}" >
  <head>
    <meta charset="utf-8" />

    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="referrer" content="no-referrer" />
    {{ $template->ui->metaCsrf() }}
    
    <title>{{ $title }}</title>

    <link type="image/png" rel="shortcut icon" href="{{ $template->storage->name($template->settings->favicon)->get() }}">

    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet" type="text/css"/>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,400,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">

    {{ $template->asset->getCss('dashboard'); }}

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

        {% component sidebar-menu.tpl %}

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
                        <span class="d-none d-md-inline-block text-muted">{{ translate("tr_bfc95980634bf529e8a406db2c842b31") }}</span>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="header-search-container" >
                  <div class="navbar-search-wrapper search-input-wrapper">
                    <input  type="text" class="form-control header-search-input border-0 ps-0 min-width-300" placeholder="{{ translate("tr_dbf4c0c4d4c3758ffb5fce75401b127c") }}" />
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
                          <h5 class="text-body mb-0 me-auto">{{ translate("tr_2fc413929104c1a09ae0a66c48ce0902") }}</h5>
                        </div>
                      </div>
                      <div class="header-favorites-scrollable-container" >
                        <div class="dropdown-shortcuts-list header-favorites-container">{{ $template->system->getSystemFavorites() }}</div>
                      </div>
                    </div>
                  </li>

                  {% if($template->user->verificationAccess('view', 'dashboard-chat')->status): %}
                  <li class="nav-item"><a href="#" class="actionLoadCanvasChat" data-bs-toggle="offcanvas" data-bs-target="#offcanvasChat" ><i class="ti ti-messages ti-md icon-hover-color"></i> <span class="labelChatCountMessages badge-rounded-count"></span> </a></li>
                  {% endif %}

                  {% if($template->user->verificationAccess('view', 'dashboard-settings')->status): %}
                  <li class="nav-item"><a href="{{ $template->router->getRoute('dashboard-settings') }}" ><i class="ti ti-settings ti-md icon-hover-color"></i></a></li>
                  {% endif %}

                  <li class="nav-item"><a href="{{ getHost() }}" target="_blank" ><i class="ti ti-external-link ti-md icon-hover-color"></i></a></li>

                  <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <span class="nav-link dropdown-toggle hide-arrow pe-0 ps-0" data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                        <img src="{{ $template->user->data->avatar_src }}" class="image-autofocus rounded-circle" />
                      </div>
                    </span>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="{{ $template->router->getRoute('dashboard-user-card', [$template->user->data->id]) }}">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar avatar-online">
                                <img src="{{ $template->user->data->avatar_src }}" class="image-autofocus rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <span class="fw-medium d-block">{{ $template->user->data->short_name }}</span>
                              <small class="text-muted">{{ translateField($template->user->data->role->name) }}</small>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      <li>
                        <a class="dropdown-item" href="{{ $template->router->getRoute('dashboard-logout') }}" >
                          <i class="ti ti-logout me-2 ti-sm"></i>
                          <span class="align-middle">{{ translate("tr_8ef2d61ae629c63b155ae66c3d2fc9fa") }}</span>
                        </a>
                      </li>
                    </ul>
                  </li>

                </ul>
              </div>

          </nav>

          <div class="content-wrapper">
        
            {% yield content %}

          </div>

        </div>

      </div>

      <div class="layout-overlay layout-menu-toggle"></div>

    </div>


    <div class="content-backdrop fade"></div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCustomizeTemplate" aria-labelledby="offcanvasCustomizeTemplateLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title no-bold">{{ translate("tr_5af752b3d7b78f0935b58dc5d0dfc68a") }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <hr class="mt-0 mb-0" >
      <div class="offcanvas-body mx-0 flex-grow-0">

        <form class="formCustomizeTemplate" >

          <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#offcanvasCustomizeTemplateTab1" aria-controls="offcanvasCustomizeTemplateTab1" aria-selected="true">
                {{ translate("tr_cecdd096144eccaeb28c4c2bc233ed63") }}
              </button>
            </li>
            {% if($template->user->verificationAccess('view', 'dashboard-home')->status): %}
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#offcanvasCustomizeTemplateTab2" aria-controls="offcanvasCustomizeTemplateTab2" aria-selected="false" tabindex="-1">
                {{ translate("tr_231418fb670218517f1efa529ef62044") }}
              </button>
            </li>
            {% endif %}
          </ul>

          <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="offcanvasCustomizeTemplateTab1" role="tabpanel">

              <div><span class="bg-label-primary rounded-1 py-1 px-2">{{ translate("tr_0577df9ad7a2256702cd04371b2abecb") }}</span></div>

              <div class="mt-3 w-100">
                <select name="template_language" class="form-select selectpicker" >
                  {% $template->component->translate->outLanguagesOptions($template->system->getSystemTemplate()->language) %}
                </select>
              </div>

              <div class="mt-4" ><span class="bg-label-primary rounded-1 py-1 px-2">{{ translate("tr_9e26d3c026ab4079d3967e7038b4d948") }}</span></div>

              <div class="mt-3 w-100">
                <div class="row px-1 template-customize-styles-options">
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-icon mb-0 {% if($template->system->getSystemTemplate()->theme_color == 'light'): echo 'checked'; endif %}">
                      <label class="form-check-label custom-option-content p-0" for="templateThemeColorLight">
                        <span class="custom-option-body mb-0">
                          <img src="{{ $template->storage->getAssetImage('light.svg') }}" class="img-fluid scaleX-n1-rtl">
                        </span>
                        <input name="template_theme_color" class="form-check-input d-none" type="radio" value="light" id="templateThemeColorLight" {% if($template->system->getSystemTemplate()->theme_color == 'light'): echo 'checked="checked"'; endif %} >
                      </label>
                    </div>
                    <label class="form-check-label small text-nowrap">{{ translate("tr_cc8596f1aaba8d13e52b92bafeb63bf0") }}</label>
                  </div>
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-icon mb-0 {% if($template->system->getSystemTemplate()->theme_color == 'dark'): echo 'checked'; endif %}">
                      <label class="form-check-label custom-option-content p-0" for="templateThemeColorDark">
                        <span class="custom-option-body mb-0">
                          <img src="{{ $template->storage->getAssetImage('dark.svg') }}" class="img-fluid scaleX-n1-rtl">
                        </span>
                        <input name="template_theme_color" class="form-check-input d-none" type="radio" value="dark" id="templateThemeColorDark" {% if($template->system->getSystemTemplate()->theme_color == 'dark'): echo 'checked="checked"'; endif %} >
                      </label>
                    </div>
                    <label class="form-check-label small text-nowrap">{{ translate("tr_02973823338195823c97bf0b6444524c") }}</label>
                  </div>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="offcanvasCustomizeTemplateTab2" role="tabpanel">

             <ul class="list-group list-group-flush" >
                {{ $template->system->getSystemHomeWidgets() }}
             </ul>

            </div>
          </div>

          <button class="mt-4 w-100 btn btn-primary waves-effect waves-light buttonSaveOffcanvasCustomizeTemplate">{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</button>

        </form>

      </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAuthUniId" aria-labelledby="offcanvasAuthUniIdLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title ">{{ translate("tr_628f580197e1936f25246567e8aa80c1") }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <hr class="mt-0 mb-0" >
      <div class="offcanvas-body my-0 mx-0 flex-grow-0">

        <div class="mt-4">

          <div class="text-center" >
            <img src="{{ $template->settings->uni_api_link }}/assets/logo/uni-id.png" height="74" class="mb-2" >
          </div>

          <form class="formAuthUniId" >

             <label class="form-label" >{{ translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d") }}</label>
             <input type="text" class="form-control" name="login" >

             <label class="form-label mt-2" >{{ translate("tr_5ebe553e01799a927b1d045924bbd4fd") }}</label>
             <input type="password" class="form-control" name="password" >

            <button class="mt-4 w-100 btn btn-primary waves-effect waves-light actionAuthUniId">{{ translate("tr_63a753751e8899416d62b1d1bbb61720") }}</button>

          </form>
          
        </div>

      </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasChat" aria-labelledby="offcanvasChatLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title ">{{ translate("tr_378f419c63a1401d9be1d3cc87b432bc") }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <hr class="mt-0 mb-0" >
      <div class="offcanvas-body my-0 mx-0 flex-grow-0">

        <div class="offcanvas-chat-content-dialogues" ></div> 

      </div>
    </div>

    <div class="template-customize-open-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCustomizeTemplate" ></div>

    {{ $template->ui->tpl("forbidden.tpl")->modal("forbidden", "small") }}
    {{ $template->ui->tpl("test-log.tpl")->modal("testLog", "medium") }}
    {{ $template->ui->tpl("load-content.tpl")->modal("loadContent", "medium") }}
    {{ $template->ui->tpl("filemanager.tpl")->modal("fileManager", "mega") }}
    {{ $template->ui->tpl("widget-notification-cron.tpl")->modal("widgetNotificationCron", "medium") }}

    {{ $template->asset->getJs('dashboard') }}

  </body>
</html>