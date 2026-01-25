{% component breadcrumbs.tpl %}

<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
    <li class="nav-item"><a class="nav-link waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-services') }}">{{ translate("tr_4e1a0e95e6e3f392f99811caba17f550") }}</a></li>
    <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="{{ $template->router->getRoute('dashboard-services-tariffs') }}">{{ translate("tr_a49106cadab8ae1ff6a37e7ccea9c665") }}</a></li>
  </ul>
</div>

<div class="row g-4">

  <div class="col-12 col-md-12">

    {% component services/tariff-statistics.tpl %}

    <div class="card" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

          <div class="control-filters-container" >

            <div class="control-filters-container-item" >
              <div class="btn-group flex-wrap">

                  <div class="btn-group">
                    <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                    </button>
                    <ul class="dropdown-menu width100" >
                      <li><span class="dropdown-item openModal" data-modal-id="addServiceTariffModal" >{{ translate("tr_5eba283b81890978e67f4aa96dde1724") }}</span></li>
                      <li><span class="dropdown-item openModal" data-modal-id="servicesTariffModal" >{{ translate("tr_3fe5f0843cba1f2227f301a4b5564787") }}</span></li>
                    </ul>
                  </div>

              </div>
            </div>

          </div>

        </div>
      </div>

      {% component services/tariff-list.tpl %}

    </div>

  </div>

</div>

{{ $template->ui->tpl('services/add-tariff.tpl')->modal("addServiceTariff", "medium") }}
{{ $template->ui->tpl('services/services-tariff.tpl')->modal("servicesTariff", "medium") }}