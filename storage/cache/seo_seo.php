<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/seo" >Seo</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-seo" data-page-icon="ti-template" data-page-name="Seo" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12 col-lg-3">

    <div class="nav-align-left">

        <ul class="nav nav-pills w-100">

          <?php echo $template->component->seo->outSections();; ?>
          
        </ul>

    </div>

  </div>

  <div class="col-12 col-lg-9">

    <div class="card" >
      
      <div class="card-body" >

        <?php echo $template->ui->wrapperInfo("dashboard-change-section");; ?>

      </div>

    </div>

  </div>

</div>