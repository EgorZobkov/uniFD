<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/settings" >Настройки</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-settings" data-page-icon="ti-settings" data-page-name="Настройки" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12 col-lg-3">
    <div class="d-flex justify-content-between flex-column mb-3 mb-md-0">
      <ul class="nav nav-align-left nav-pills flex-column">
        
        <?php echo $template->component->settings->outSections();; ?>

      </ul>
    </div>
  </div>

  <div class="col-12 col-lg-9 pt-4 pt-lg-0">
    <form class="formSettings" method="post" >

        <?php echo $template->component->settings->outSectionContent();; ?>
    
    </form>
  </div>

</div>