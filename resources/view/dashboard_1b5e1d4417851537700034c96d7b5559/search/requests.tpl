{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-search-keywords') }}">{{ translate("tr_83dc72c7b853982cd4d3cbddf0254061") }}</a></li>
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-search-requests') }}">{{ translate("tr_96dd456b0406016c4c15ac8ac4afc3fc") }}</a></li>
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

          <div class="control-filters-container-item" >
              <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                </button>
                <ul class="dropdown-menu width100" >
                  <li><span class="dropdown-item actionSearchClearRequests" >{{ translate("tr_b78d3b29efd67397db0787f9f64b33a0") }}</span></li>
                </ul>
              </div>
          </div>

          </div>

        </div>
      </div>

      </form>

      {% component search/requests.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>

</div>