<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/mobile-app/stat" >Статистика приложения</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-mobile-app-stat" data-page-icon="ti-device-mobile" data-page-name="Статистика приложения" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12">

    <div class="row" >

<div class="col-lg-6 col-12 mb-4">
<div class="card" style="min-height: 430px;" >
  <div class="card-header d-flex align-items-center justify-content-between">
    <div class="card-title mb-0">
      <h4 class="mb-0">Сводка за неделю</h4>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-12 col-md-4 d-flex flex-column align-self-end">
        <div class="d-flex gap-2 align-items-center mb-0 pb-0 flex-wrap">
          <h1 class="mb-0">0</h1>
        </div>
        <small>Установок за сегодня</small>
      </div>
      <div class="col-12 col-md-8" >
        <div id="weeklyMobileAppStatReports" style="min-height: 210px;" ></div>
      </div>
    </div>
    <div class="border rounded p-3 mt-4">
      <div class="row">
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0">0</h3>
          </div>
          <p class="mb-0">Всего установок</p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0">0</h3>
          </div>
          <p class="mb-0">Активных сессий</p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="col-lg-6 col-12 mb-4">
    <div class="card" style="min-height: 430px;">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h4 class="m-0 me-2">Установок за Январь</h4>
        </div>
      </div>
      <div class="card-body">
        <div id="monthMobileAppStatReports" style="min-height: 210px;"></div>
      </div>
    </div>
</div>

</div>

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

          <div class="control-filters-container" >

          <div class="control-filters-container-item" >
  <div class="btn-group">
      <select class="form-select selectpicker formControlDefaultFilters" name="output" >
        <option value="100" <?php if($_POST['output'] == 100){ echo 'selected=""'; }; ?> >Выводить по 100</option>
        <option value="150" <?php if($_POST['output'] == 150){ echo 'selected=""'; }; ?> >Выводить по 150</option>
        <option value="300" <?php if($_POST['output'] == 300){ echo 'selected=""'; }; ?> >Выводить по 300</option>
        <option value="500" <?php if($_POST['output'] == 500){ echo 'selected=""'; }; ?> >Выводить по 500</option>
        <option value="1000" <?php if($_POST['output'] == 1000){ echo 'selected=""'; }; ?> >Выводить по 1000</option>
      </select>
  </div>
</div>

          </div>

        </div>
      </div>

      </form>

      
                <div class="wrapper-image-no-data" >
                    <img src="/resources/view/dashboard_1b5e1d4417851537700034c96d7b5559/assets/images/0020193778848547.webp" />
                    <h3>Данных нет</h3>
                    <p>Но скоро обязательно будут 😀</p>
                </div>
                

    </div>

    <?php if($template->pagination->totalItems):; ?>
    <div class="mt-4 text-muted" ><?php echo translate("tr_6697cca28b154d276b9b1e9795ac7230"); ?> <strong><?php echo $template->pagination->totalItems; ?></strong>, <?php echo translate("tr_932b3194a5406d1e30c4f7d91d1c161f"); ?> <strong><?php echo $template->pagination->totalPages; ?></strong></div>
    <?php endif;; ?>

    <?php echo $template->pagination->display(); ?>

  </div>
</div>