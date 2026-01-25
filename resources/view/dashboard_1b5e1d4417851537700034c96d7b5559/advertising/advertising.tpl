
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12">

    {% component advertising/statistics.tpl %}

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

            <div class="control-filters-container" >
            
            {% component control-filters-output.tpl %}

            <div class="control-filters-container-item" >
              <div class="btn-group">

                  <div class="btn-group">
                    <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                    </button>
                    <ul class="dropdown-menu width100" >
                      <li><span class="dropdown-item openModal" data-modal-id="addAdvertisingModal" >{{ translate("tr_5eba283b81890978e67f4aa96dde1724") }}</span></li>
                    </ul>
                  </div>

              </div>
            </div>

            </div>

        </div>
      </div>

      </form>

      {% component advertising/list.tpl %}

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>
</div>

{{ $template->ui->tpl('advertising/add-advertising.tpl')->modal("addAdvertising", "medium"); }}
{{ $template->ui->tpl('advertising/code-advertising.tpl')->modal("codeAdvertising", "small"); }}
