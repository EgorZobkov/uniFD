<!doctype html>

<html lang="{{ $template->translate->current->iso }}" >
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $seo->meta_title }}</title>

    <meta name="description" content="{{ $seo->meta_desc }}">
    {{ $template->ui->metaCsrf() }}

    <link type="image/png" rel="shortcut icon" href="{{ $template->storage->name($template->settings->favicon)->get() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Noto+Sans+KR:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&family=Ubuntu+Sans+Mono:ital,wght@0,400..700;1,400..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <meta property="og:site_name" content="{{ $template->settings->project_name }}">
    <meta property="og:type" content="website">

    {% yield head %}

    {{ $template->asset->getCss('web') }}

  </head>

  <body>

    <section class="flex-wrapper" >

      {% extends header.tpl %}

      {% yield content %}

    </section>

    {% extends footer.tpl %}

    {{ $template->asset->getJs('web') }}

    <noindex>

    {{ $template->ui->tpl('modals/geo-modal.tpl')->modal("geo", "big") }}
    {{ $template->ui->tpl('profile/chat/modal.tpl')->modal("chat", "big") }}
    {{ $template->ui->tpl('modals/payment-modal.tpl')->modal("payment", "medium") }}

    {{ htmlspecialchars_decode($template->settings->frontend_scripts) }}

    </noindex>

  </body>
</html>