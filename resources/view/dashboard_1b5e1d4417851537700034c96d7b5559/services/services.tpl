{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-services') }}">{{ translate("tr_4e1a0e95e6e3f392f99811caba17f550") }}</a></li>
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-services-tariffs') }}">{{ translate("tr_a49106cadab8ae1ff6a37e7ccea9c665") }}</a></li>
  </ul>
</div>

<div class="row g-4">

  <div class="col-12 col-md-12">

    {% component services/statistics.tpl %}

    <div class="card" >

      {% component services/list.tpl %}

    </div>

  </div>

</div>