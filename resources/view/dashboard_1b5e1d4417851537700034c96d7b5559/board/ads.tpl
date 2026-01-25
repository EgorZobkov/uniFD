{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12 col-md-12">

    {% component board/ads/statistics.tpl %}

    <ul class="nav nav-pills mb-3" role="tablist">
      
        <li class="nav-item" role="presentation">
          <a href="{{ $template->router->getRoute('dashboard-ads') }}" class="nav-link {% if(!isset($_POST['filter']['status'])){ echo 'active'; } %}">
            {{ translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d") }}
          </a>
        </li>

      {% foreach ($template->component->ads->allStatuses() as $key => $value): %}

        <li class="nav-item" role="presentation">
          <a href="{{ requestBuildVars(['filter'=>['status'=>$value['status']]]) }}" class="nav-link {% if(isset($_POST['filter']['status'])){ if($value['status'] == $_POST['filter']['status']){ echo 'active'; } } %}">
            {{ $value['name_declension'] }}
            <span class="badge badge-auto bg-label-primary rounded-pill badge-center ms-1">{{ $template->component->ads_counter->getCountByStatus($value['status']) }}</span>
          </a>
        </li>

      {% endforeach; %}

    </ul>

    <div class="card" >

      <form class="formControlFilters" >

        <div class="card-header flex-column flex-md-row">
          <div class="text-end pt-3 pt-md-0">

            <div class="actionsWithSelectedItems" >
              <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ translate("tr_5a1b889ac2877c8aac10a101e6925446") }} <span class="actionsWithSelectedItemsCount" ></span>
                </button>
                <ul class="dropdown-menu" >
                  <li><span class="dropdown-item actionChangeMultiStatus" data-status="1" >{{ translate("tr_fd47eb2e78af443b8fac35a0ca0a5e0a") }}</span></li>
                  <li><span class="dropdown-item actionChangeMultiStatus" data-status="3" >{{ translate("tr_af1939bb99d547ff54c8623ba556ab5a") }}</span></li>
                  <li><span class="dropdown-item actionAdsMultiToExtend" >{{ translate("tr_18284259d971525f8d0bf9ae23871fcd") }}</span></li>
                  <li><span class="dropdown-item actionAdsMultiDelete" >{{ translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8") }}</span></li>
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

            <div class="control-filters-container-item" >
              <div class="btn-group flex-wrap">

                  <div class="btn-group">
                    <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                    </button>
                    <ul class="dropdown-menu width100" >
                      <li><a class="dropdown-item" href="{{ $template->router->getRoute('dashboard-import-export').'?table=ads' }}" >{{ translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5") }}</a></li>
                    </ul>
                  </div>

              </div>
            </div>

            </div>

          </div>
        </div>

        {{ $template->ui->tpl('board/ads/control-filters.tpl')->modal("controlFilters", "small"); }}

      </form>

      {% component board/ads/list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>

</div>