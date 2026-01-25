<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/promo/banners" >Промо баннеры</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-promo-banners" data-page-icon="ti-photo" data-page-name="Промо баннеры" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12">

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
                  <li><span class="dropdown-item openModal" data-modal-id="addPromoBannerModal" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span></li>
                </ul>
              </div>

          </div>
          </div>

          </div>

        </div>
      </div>

      </form>

      <div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span>Заголовок</span></th>
        <th><span>Статус</span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      
            <tr>
              <td>
                Купить BMW до 3 000 000 руб              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-secondary me-1">Не активно</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditBanner" data-id="5" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteBanner" data-id="5" >
                    <i class="ti ti-xs ti-trash"></i>
                  </button>

                </div>                

              </td>
            </tr>

            
            <tr>
              <td>
                Срочная продажа Авто              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-secondary me-1">Не активно</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditBanner" data-id="4" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteBanner" data-id="4" >
                    <i class="ti ti-xs ti-trash"></i>
                  </button>

                </div>                

              </td>
            </tr>

            
            <tr>
              <td>
                Скрипты и программное обеспечение              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-secondary me-1">Не активно</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditBanner" data-id="3" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteBanner" data-id="3" >
                    <i class="ti ti-xs ti-trash"></i>
                  </button>

                </div>                

              </td>
            </tr>

            
            <tr>
              <td>
                Видеокурсы              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-secondary me-1">Не активно</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditBanner" data-id="2" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteBanner" data-id="2" >
                    <i class="ti ti-xs ti-trash"></i>
                  </button>

                </div>                

              </td>
            </tr>

            
    </tbody>
  </table>
</div>


    </div>

    <?php if($template->pagination->totalItems):; ?>
    <div class="mt-4 text-muted" ><?php echo translate("tr_6697cca28b154d276b9b1e9795ac7230"); ?> <strong><?php echo $template->pagination->totalItems; ?></strong>, <?php echo translate("tr_932b3194a5406d1e30c4f7d91d1c161f"); ?> <strong><?php echo $template->pagination->totalPages; ?></strong></div>
    <?php endif;; ?>

    <?php echo $template->pagination->display(); ?>

  </div>
</div>

<?php echo $template->ui->tpl('promo-banners/add.tpl')->modal("addPromoBanner", "medium");; ?>