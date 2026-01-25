
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    {% if(!$template->settings->frontend_scripts): %}
    <div class="alert alert-warning d-flex align-items-center mt-0 mb-3" role="alert">
      {{ translate("tr_e9e5d2f9c1d8cdb2bb88de79362ca60b") }} <a href="{{ $template->router->getRoute("dashboard-settings-systems") }}/#systems-scripts">{{ translate("tr_b4484a2be5cc2633b3d1ce1d2585af3c") }}</a>
    </div>
    {% endif %}

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

          {% component control-filters-output.tpl %}

        </div>
      </div>

      </form>

      {% component users/traffic-list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>
</div>
