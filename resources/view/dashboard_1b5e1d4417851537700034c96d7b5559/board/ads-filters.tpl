{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12 col-md-12">

    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills flex-column flex-md-row">
        <li class="nav-item">
          <a class="nav-link active" href="{{ $template->router->getRoute('dashboard-ads-filters'); }}">{{ translate("tr_f7ac6fc5c5a477063add9c6d0701985d") }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ $template->router->getRoute('dashboard-ads-filters-links'); }}">{{ translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f") }}</a>
        </li>
    </div>

    <div class="card" >

      <form class="formControlFilters" >

        <div class="card-header flex-column flex-md-row">
          <div class="text-end pt-3 pt-md-0">

            <div class="control-filters-container" >

            {% component control-filters-output.tpl %}
            {% component control-filters-search.tpl %}

            <div class="control-filters-container-item" >
            <div class="btn-group">

                <select class="form-select formControlDefaultFilters selectpicker selectFilterCategoryId" data-live-search="true" title="{{ translate("tr_53660e081bed47bc53e7d4d247f7b15d") }}" name="filter[category_id]" >
                  <option value="" >{{ translate("tr_53660e081bed47bc53e7d4d247f7b15d") }}</option>
                  {{ $template->component->ads_categories->selectedIds($_POST['filter']['category_id'])->getRecursionOptions() }}
                </select>

            </div>
            </div>

            <div class="control-filters-container-item" >
            <div class="btn-group">

                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                  </button>
                  <ul class="dropdown-menu width100" >
                    <li><span class="dropdown-item openModal" data-modal-id="addFilterModal" >{{ translate("tr_5eba283b81890978e67f4aa96dde1724") }}</span></li>
                  </ul>
                </div>

            </div>
            </div>

            </div>

          </div>
        </div>

      </form>

      {% component board/filters/list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>

</div>

{{ $template->ui->tpl('board/filters/add-filter.tpl')->modal("addFilter", "medium"); }}
{{ $template->ui->tpl('board/filters/add-list-items-filter.tpl')->modal("addListItemsFilter", "small"); }}