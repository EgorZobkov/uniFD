<!doctype html>

<html lang="ru" class="light-style layout-wide customizer-hide" >
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }}</title>
    {{ $template->ui->metaCsrf() }}

    <link type="image/png" rel="shortcut icon" href="{{ $template->storage->name($template->settings->favicon)->get() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    {{ $template->asset->getCss('dashboard'); }}

  </head>

  <body>

    <div class="authentication-wrapper authentication-cover">

      <div class="authentication-inner row m-0">

        <div class="d-none d-xl-flex col-xl-7 p-0">
          <div class="auth-cover-bg d-flex justify-content-center align-items-center">
             <div class="auth-illustration" >
               <img src="" />
             </div>
          </div>
        </div>

        <div class="d-flex col-12 col-xl-5 align-items-center authentication-bg p-sm-12 p-6">
          <div class="w-px-400 mx-auto mt-12 pt-5">

              <h3 class="mb-3 pt-2">{{ translate("tr_139ff22e13842f1a599c1c3c9d2a7ee7") }} {{ translate("tr_bf44672226a49cab577451711c25eb59") }} {{ $template->settings->project_name }}!👋</h3>

              <form class="formAuthentication" method="get">
                <div class="mb-3">
                  <label for="email" class="form-label">{{ translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d") }}</label>
                  <input type="text" class="form-control" name="login" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">{{ translate("tr_5ebe553e01799a927b1d045924bbd4fd") }}</label>
                    <a href="{{ $template->router->getRoute('dashboard-forgot') }}">
                      <small>{{ translate("tr_38bb0dceaeccc88640465bf53a63481f") }}</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" class="form-control input-password" name="password" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer password-reveal-toggle"><i class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="switch">
                    <input type="checkbox" class="switch-input" value="1" name="remember_me" >
                    <span class="switch-toggle-slider">
                      <span class="switch-on"></span>
                      <span class="switch-off"></span>
                    </span>
                    <span class="switch-label">{{ translate("tr_978f6ae28acd9e1d2d15f598f0d3ff8c") }}</span>
                  </label>
                </div>
                <button class="btn btn-primary waves-effect waves-light w-100 formAuthenticationButtonEnter" >{{ translate("tr_63a753751e8899416d62b1d1bbb61720") }}</button>
              </form>

          </div>
        </div>

      </div>
    </div>

    <div class="content-backdrop fade"></div>

    {{ $template->asset->getJs('dashboard'); }}

  </body>
</html>

{{ $template->ui->tpl("captcha.tpl")->modal("captcha", "nano"); }}

