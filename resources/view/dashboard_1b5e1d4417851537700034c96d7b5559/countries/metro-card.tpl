{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-country-city-card', [$data->id]) }}">{{ translate("tr_73d7050e5b86bed85fdc6182c27b7d59") }}</a></li>
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-country-city-metro-card', [$data->id]) }}">{{ translate("tr_bf81bef60d4246393b8391e940a00e3d") }}</a></li>
  </ul>
</div>

<div class="row g-4">

  <div class="col-12 col-md-12">

    <div class="card" >

      <form class="formControlFilters" >

        <div class="card-header flex-column flex-md-row">
          <div class="text-end pt-3 pt-md-0">

            <div class="control-filters-container" >

            {% component control-filters-output.tpl %}
            {% component control-filters-search.tpl %}

            <div class="control-filters-container-item" >
            <div class="btn-group">
                <div class="btn btn-primary text-nowrap openModal" data-modal-id="addCityMetroModal" >{{ translate("tr_ef0d43331c9863723e62e22d29a61f2c") }}</div>
            </div>
            </div>

            </div>

          </div>
        </div>

      </form>

      {% component countries/metro.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>

</div>

{{ $template->ui->tpl('countries/add-city-metro.tpl')->modal("addCityMetro", "small", $data); }}