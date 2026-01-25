
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
        <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-import-export') }}">{{ translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5") }}</a></li>
        <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-import-export-feeds') }}">{{ translate("tr_f87bd387ab8ed79f1af55bbb3a644b86") }}</a></li>
      </ul>
    </div>

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

          <div class="control-filters-container" >

          {% component control-filters-output.tpl %}
          {% component control-filters-search.tpl %}

          <div class="control-filters-container-item" >
            <div class="btn-group">
              <button type="button" class="btn btn-label-secondary waves-effect waves-light openModal" data-modal-id="controlFiltersModal" >{{ translate("tr_2f884b41fe8b0f3ff6420fb84ce7872c") }} {% if($_POST['filter']){ echo '<span class="badge badge-dot bg-danger ms-1"></span>'; } %}</button>
            </div>
          </div>

          <div class="control-filters-container-item" >
            <div class="btn-group">

                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                  </button>
                  <ul class="dropdown-menu width100" >
                    <li><span class="dropdown-item openModal" data-modal-id="addTaskModal" >{{ translate("tr_0f1cf42b49693b3368990e74dfec2a64") }}</span></li>
                  </ul>
                </div>

            </div>
          </div>

          </div>

        </div>
      </div>

      {{ $template->ui->tpl('import-export/control-filters.tpl')->modal("controlFilters", "small"); }}

      </form>

      {% component import-export/list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>
</div>

{{ $template->ui->tpl('import-export/add-task.tpl')->modal("addTask", "small"); }}