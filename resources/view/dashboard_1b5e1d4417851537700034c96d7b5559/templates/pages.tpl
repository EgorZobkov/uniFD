
{% component breadcrumbs.tpl %}

<div class="row g-4">

  <div class="col-12 col-lg-3">

    <div class="nav-align-left">

        <ul class="nav nav-pills w-100" >
          {{ $template->component->templates->outSections(); }}        
        </ul>

    </div>

  </div>

  <div class="col-12 col-lg-9">

    <div class="card-header flex-column flex-md-row">
      <div class="text-end pt-3 pt-md-0">

        <div class="btn-group flex-wrap">

            <button class="btn btn-primary waves-effect waves-light w-100 openModal" data-modal-id="templateAddPageModal" >{{ translate("tr_c1423e381b18426e6ab959551b96589a") }}</button>

        </div>

      </div>
    </div>

    <div class="card mt-3" >

        <div class="list-group list-group-flush">
            {{ $template->component->templates->getPages(); }}
        </div>

    </div>

  </div>

</div>

{{ $template->ui->tpl('templates/add-page.tpl')->modal("templateAddPage", "small"); }}