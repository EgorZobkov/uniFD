<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/ads" >Объявления</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-ads" data-page-icon="ti-barcode" data-page-name="Объявления" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12 col-md-12">

    <div class="row" >

<div class="col-lg-12 col-12 mb-4">
    <div class="card" style="min-height: 400px;">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h4 class="m-0 me-2">Статистика публикаций за Январь</h4>
        </div>
      </div>
      <div class="card-body">
        <div id="monthReports" style="min-height: 210px;"></div>
      </div>
    </div>
</div>

</div>

    <ul class="nav nav-pills mb-3" role="tablist">
      
        <li class="nav-item" role="presentation">
          <a href="<?php echo $template->router->getRoute('dashboard-ads'); ?>" class="nav-link <?php if(!isset($_POST['filter']['status'])){ echo 'active'; }; ?>">
            <?php echo translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d"); ?>
          </a>
        </li>

      <?php foreach ($template->component->ads->allStatuses() as $key => $value):; ?>

        <li class="nav-item" role="presentation">
          <a href="<?php echo requestBuildVars(['filter'=>['status'=>$value['status']]]); ?>" class="nav-link <?php if(isset($_POST['filter']['status'])){ if($value['status'] == $_POST['filter']['status']){ echo 'active'; } }; ?>">
            <?php echo $value['name_declension']; ?>
            <span class="badge badge-auto bg-label-primary rounded-pill badge-center ms-1"><?php echo $template->component->ads_counter->getCountByStatus($value['status']); ?></span>
          </a>
        </li>

      <?php endforeach;; ?>

    </ul>

    <div class="card" >

      <form class="formControlFilters" >

        <div class="card-header flex-column flex-md-row">
          <div class="text-end pt-3 pt-md-0">

            <div class="actionsWithSelectedItems" >
              <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo translate("tr_5a1b889ac2877c8aac10a101e6925446"); ?> <span class="actionsWithSelectedItemsCount" ></span>
                </button>
                <ul class="dropdown-menu" >
                  <li><span class="dropdown-item actionChangeMultiStatus" data-status="1" ><?php echo translate("tr_fd47eb2e78af443b8fac35a0ca0a5e0a"); ?></span></li>
                  <li><span class="dropdown-item actionChangeMultiStatus" data-status="3" ><?php echo translate("tr_af1939bb99d547ff54c8623ba556ab5a"); ?></span></li>
                  <li><span class="dropdown-item actionAdsMultiToExtend" ><?php echo translate("tr_18284259d971525f8d0bf9ae23871fcd"); ?></span></li>
                  <li><span class="dropdown-item actionAdsMultiDelete" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span></li>
                </ul>
              </div>
            </div>

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
            <div class="control-filters-container-item" >
  <div class="btn-group">
      <div class="input-group input-group-merge">
        <span class="input-group-text" ><i class="ti ti-search"></i></span>
        <input type="text" class="form-control formControlDefaultFilters" placeholder="Поиск..." name="search" value="<?php echo $_POST['search']; ?>" >
      </div>
  </div>
</div>

            <div class="control-filters-container-item" >
              <div class="btn-group">
                <button type="button" class="btn btn-label-secondary waves-effect waves-light openModal" data-modal-id="controlFiltersModal" ><?php echo translate("tr_2f884b41fe8b0f3ff6420fb84ce7872c"); ?> <?php if($_POST['filter']){ echo '<span class="badge badge-dot bg-danger ms-1"></span>'; }; ?></button>
              </div>
            </div>

            <div class="control-filters-container-item" >
              <div class="btn-group flex-wrap">

                  <div class="btn-group">
                    <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?>
                    </button>
                    <ul class="dropdown-menu width100" >
                      <li><a class="dropdown-item" href="<?php echo $template->router->getRoute('dashboard-import-export').'?table=ads'; ?>" ><?php echo translate("tr_20ee8ea20203fd1ea3fbc9d120467ec5"); ?></a></li>
                    </ul>
                  </div>

              </div>
            </div>

            </div>

          </div>
        </div>

        <?php echo $template->ui->tpl('board/ads/control-filters.tpl')->modal("controlFilters", "small");; ?>

      </form>

      
                <div class="wrapper-image-no-data" >
                    <img src="/resources/view/dashboard_1b5e1d4417851537700034c96d7b5559/assets/images/0020193778848547.webp" />
                    <h3>Объявлений нет</h3>
                    <p>Но скоро обязательно появятся</p>
                </div>
                

    </div>

    <?php if($template->pagination->totalItems):; ?>
    <div class="mt-4 text-muted" ><?php echo translate("tr_6697cca28b154d276b9b1e9795ac7230"); ?> <strong><?php echo $template->pagination->totalItems; ?></strong>, <?php echo translate("tr_932b3194a5406d1e30c4f7d91d1c161f"); ?> <strong><?php echo $template->pagination->totalPages; ?></strong></div>
    <?php endif;; ?>

    <?php echo $template->pagination->display(); ?>

  </div>

</div>