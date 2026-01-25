{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-country-card', [$data->id]) }}">{{ translate("tr_e4775a4f4afed1b72fd3a52a9545e3cf") }}</a></li>
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-country-regions-card', [$data->id]) }}">{{ translate("tr_81b8d9aded466a2ad70e6dcdd34d22a2") }}</a></li>
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
                <div class="btn btn-primary text-nowrap openModal" data-modal-id="addRegionModal" >{{ translate("tr_250cac35a07c98e34ad59684fd302953") }}</div>
            </div>
            </div>

            </div>

          </div>
        </div>

      </form>

      {% component countries/regions.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>

</div>

{{ $template->ui->tpl('countries/add-region.tpl')->modal("addRegion", "medium", $data); }}
