
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12 col-lg-4" >

    <div class="card mb-0" >
      <div class="card-body">

        <h5 class="mb-0 font-weight-bold-800 update-container-info-version">{{ translate("tr_69f748c792e4aaeeedf8cc3fafae0c6f") }}</h5>
        <p class="mb-0">{{ translate("tr_0f7ed274553216cfccbc32a78fd8b01c") }} {{ $template->settings->system_version }}</p>
        <p class="mb-0">{{ translate("tr_48e37c9cc1750fe6b8c20e2c18be801f") }} {{ $template->datetime->outDate($template->settings->system_last_update) }}</p>

        <div class="update-container-button-install" >
          {% if($template->settings->uniid_token): %}
          <button class="btn btn-dark waves-effect waves-light mt-3 openModal" data-modal-id="confirmationUpdateModal" >{{ translate("tr_7fe136f1b9b0989067f0cacfd750de74") }}</button>
          {% else: %}
          <button class="btn btn-dark waves-effect waves-light mt-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAuthUniId" >{{ translate("tr_7fe136f1b9b0989067f0cacfd750de74") }}</button>
          {% endif %}
        </div>

      </div>
    </div> 

  </div>

  <div class="col-12">

    <div class="card">

      {% component updates/list.tpl %}

    </div>

  </div>

</div>

{{ $template->ui->tpl('updates/confirmation.tpl')->modal("confirmationUpdate", "small") }}
