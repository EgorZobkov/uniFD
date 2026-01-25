
{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-transactions') }}">{{ translate("tr_cecdd096144eccaeb28c4c2bc233ed63") }}</a></li>
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-transactions-operations') }}">{{ translate("tr_1ec0db83a649974785419afafde20176") }}</a></li>
  </ul>
</div>

<div class="row g-4">

  <div class="col-12">

    {% component transactions/statistics.tpl %}

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header mb-0 pb-0">
          <div class="text-end pt-3 pt-md-0">

            <div class="actionsWithSelectedItems" >
              <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ translate("tr_5a1b889ac2877c8aac10a101e6925446") }} <span class="actionsWithSelectedItemsCount" ></span>
                </button>
                <ul class="dropdown-menu" >
                  <li><span class="dropdown-item actionTransactionMultiDelete" >{{ translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8") }}</span></li>
                </ul>
              </div>
            </div>

            <div class="control-filters-container" >

            {% component control-filters-output.tpl %}
            {% component control-filters-search.tpl %}

            <div class="control-filters-container-item" >
            <div class="btn-group">
              <button type="button" class="btn btn-label-secondary waves-effect waves-light openModal" data-modal-id="controlFiltersModal" >{{ translate("tr_2f884b41fe8b0f3ff6420fb84ce7872c") }} {% if($_POST['filter']){ echo '<span class="badge badge-dot bg-danger ms-1"></span>'; } %}</button>
            </div>
            </div>

            </div>

          </div>
      </div>

      {{ $template->ui->tpl('transactions/control-filters.tpl')->modal("controlFilters", "small"); }}

      </form>

      {% component transactions/list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>
</div>