<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/advertising" >Реклама</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-advertising" data-page-icon="ti-ad" data-page-name="Реклама" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12">

    <div class="row" >

<div class="col-lg-12 col-12 mb-4">
    <div class="card" style="min-height: 400px;">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h4 class="m-0 me-2">Статистика переходов за Январь</h4>
        </div>
      </div>
      <div class="card-body">
        <div id="monthReportsAdvertising" style="min-height: 210px;"></div>
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

            <div class="control-filters-container-item" >
              <div class="btn-group">

                  <div class="btn-group">
                    <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?>
                    </button>
                    <ul class="dropdown-menu width100" >
                      <li><span class="dropdown-item openModal" data-modal-id="addAdvertisingModal" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span></li>
                    </ul>
                  </div>

              </div>
            </div>

            </div>

        </div>
      </div>

      </form>

      
                <div class="wrapper-image-no-data" >
                    <img src="/resources/view/dashboard_1b5e1d4417851537700034c96d7b5559/assets/images/0020193778848547.webp" />
                    <h3>Рекламы нет</h3>
                    <p>Скорее добавьте ее</p>
                </div>
                

    </div>

    <?php if($template->pagination->totalItems):; ?>
    <div class="mt-4 text-muted" ><?php echo translate("tr_6697cca28b154d276b9b1e9795ac7230"); ?> <strong><?php echo $template->pagination->totalItems; ?></strong>, <?php echo translate("tr_932b3194a5406d1e30c4f7d91d1c161f"); ?> <strong><?php echo $template->pagination->totalPages; ?></strong></div>
    <?php endif;; ?>

    <?php echo $template->pagination->display(); ?>

  </div>
</div>

<?php echo $template->ui->tpl('advertising/add-advertising.tpl')->modal("addAdvertising", "medium");; ?>
<?php echo $template->ui->tpl('advertising/code-advertising.tpl')->modal("codeAdvertising", "small");; ?>