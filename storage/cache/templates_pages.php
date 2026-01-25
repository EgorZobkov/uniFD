<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/templates" >Шаблонизатор</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-templates" data-page-icon="ti-template" data-page-name="Шаблонизатор" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12 col-lg-3">

    <div class="nav-align-left">

        <ul class="nav nav-pills w-100" >
          <?php echo $template->component->templates->outSections();; ?>        
        </ul>

    </div>

  </div>

  <div class="col-12 col-lg-9">

    <div class="card-header flex-column flex-md-row">
      <div class="text-end pt-3 pt-md-0">

        <div class="btn-group flex-wrap">

            <button class="btn btn-primary waves-effect waves-light w-100 openModal" data-modal-id="templateAddPageModal" ><?php echo translate("tr_c1423e381b18426e6ab959551b96589a"); ?></button>

        </div>

      </div>
    </div>

    <div class="card mt-3" >

        <div class="list-group list-group-flush">
            <?php echo $template->component->templates->getPages();; ?>
        </div>

    </div>

  </div>

</div>

<?php echo $template->ui->tpl('templates/add-page.tpl')->modal("templateAddPage", "small");; ?>