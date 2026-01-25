{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-search-keywords') }}">{{ translate("tr_83dc72c7b853982cd4d3cbddf0254061") }}</a></li>
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-search-requests') }}">{{ translate("tr_96dd456b0406016c4c15ac8ac4afc3fc") }}</a></li>
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
                <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                </button>
                <ul class="dropdown-menu width100" >
                  <li><span class="dropdown-item openModal" data-modal-id="addSearchKeywordModal" >{{ translate("tr_5eba283b81890978e67f4aa96dde1724") }}</span></li>
                </ul>
              </div>
          </div>

          </div>

        </div>
      </div>

      </form>

      {% component search/keywords.tpl %}

    </div>

  </div>

</div>

{{ $template->ui->tpl('search/add-keyword.tpl')->modal("addSearchKeyword", "small"); }}