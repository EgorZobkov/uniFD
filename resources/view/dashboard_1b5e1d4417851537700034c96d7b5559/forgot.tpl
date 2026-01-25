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

              <h3 class="mb-1 pt-2">{{ translate("tr_f490b86156968b0c43cbf28feefacd33") }} 🔒</h3>
              <p class="mb-3">{{ translate("tr_5a2d85df62667b72374d32c321008495") }}</p>
              <form class="formAuthenticationForgot mb-3" method="get">
                <div class="mb-3">
                  <label for="email" class="form-label">{{ translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d") }}</label>
                  <input type="text" class="form-control" name="login" autofocus /> </div>
                <button class="btn btn-primary w-100 formAuthenticationButtonResetPass">{{ translate("tr_8513955adb3b7063f20d1a3b99e65398") }}</button>
              </form>
              <div class="text-center">
                <a href="{{ $template->router->getRoute('dashboard-auth') }}" class="d-flex align-items-center justify-content-center"> <i class="ti ti-chevron-left scaleX-n1-rtl"></i> {{ translate("tr_04f1e1ca3514594b1e85dce5f2b7373a") }} </a>
              </div>

          </div>
        </div>

      </div>
    </div>

    <div class="content-backdrop fade"></div>

    {{ $template->asset->getJs('dashboard'); }}

  </body>
</html>

{{ $template->ui->tpl("captcha.tpl")->modal("captcha", "nano"); }}
