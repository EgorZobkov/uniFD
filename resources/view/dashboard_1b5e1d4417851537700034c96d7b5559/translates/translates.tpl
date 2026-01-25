{% component breadcrumbs.tpl %}

{{ $template->component->translate->outLanguagesSections($_POST['iso'],$template->router->getRoute('dashboard-translates')) }}

<div class="row g-4">

  <div class="col-12">

    <div class="card" >

      <form class="formControlFilters" >

        <div class="card-header flex-column flex-md-row mb-0 pb-0">
          <div class="text-end pt-3 pt-md-0">

            <div class="control-filters-container" >

            {% if($_POST['iso']): %}

            {% component control-filters-output.tpl %}
            {% component control-filters-search.tpl %}

            <div class="control-filters-container-item" >
                <div class="btn-group">
                   <div class="btn btn-label-success text-nowrap actionSaveEditTranslatesContent" >{{ translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") }}</div>
                </div>
            </div>
            {% endif %}

            <div class="control-filters-container-item" >
                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ translate("tr_fb3df31bf52df6c142a279ecdb6dd94c") }}
                  </button>
                  <ul class="dropdown-menu" >
                    <li><span class="dropdown-item openModal" data-modal-id="languagesModal" >{{ translate("tr_cfc45c77289a8806f807b2b2f9b9655a") }}</span></li>
                    <li><span class="dropdown-item openModal" data-modal-id="addLanguageModal" >{{ translate("tr_41446bef84a7e670f7f7ab7e99d18fe0") }}</span></li>
                    <li><span class="dropdown-item actionUpdateTranslatesContent" >{{ translate("tr_e3301cba3a8328585a5d8da49efabae7") }}</span></li>
                  </ul>
                </div>
            </div>

            </div>

          </div>
        </div>

        <input type="hidden" name="iso" value="{{ $_POST['iso'] }}" >
        <input type="hidden" name="view" value="{{ $_POST['view'] }}" >

      </form>

      <div class="card-body" >

        {% if($_POST['iso']): %}

          <div class="row" >
            
            <div class="col-lg-3 col-12" >
              
              <div class="nav-align-left">

                  <ul class="nav nav-pills w-100">

                      {{ $template->component->translate->outContentSections($_POST['iso'],$_POST['view']) }}

                  </ul>

              </div>

            </div>

            <div class="col-lg-9 col-12" >
              
              <form class="formTranslatesContent" >

                <input type="hidden" name="iso" value="{{ $_POST['iso'] }}" >
                <input type="hidden" name="view" value="{{ $_POST['view'] }}" >

                {{ $template->component->translate->outContent($_POST['iso'], $_POST['view']) }}

              </form>

            </div>

          </div>

        {% else: %}

          {{ $template->ui->wrapperInfo("dashboard-change-language") }}   

        {% endif %}

      </div>

    </div>

    {% if($template->pagination->totalItems): %}
    <div class="mt-4 text-muted" >{{ translate("tr_6697cca28b154d276b9b1e9795ac7230") }} <strong>{{ $template->pagination->totalItems }}</strong>, {{ translate("tr_932b3194a5406d1e30c4f7d91d1c161f") }} <strong>{{ $template->pagination->totalPages }}</strong></div>
    {% endif; %}

    {{ $template->pagination->display() }}

  </div>

</div>

{{ $template->ui->tpl('translates/languages.tpl')->modal("languages", "medium") }}
{{ $template->ui->tpl('translates/add-language.tpl')->modal("addLanguage", "small") }}
