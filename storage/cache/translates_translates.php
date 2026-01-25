<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/translates" >Переводы</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-translates" data-page-icon="ti-language" data-page-name="Переводы" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<?php echo $template->component->translate->outLanguagesSections($_POST['iso'],$template->router->getRoute('dashboard-translates')); ?>

<div class="row g-4">

  <div class="col-12">

    <div class="card" >

      <form class="formControlFilters" >

        <div class="card-header flex-column flex-md-row mb-0 pb-0">
          <div class="text-end pt-3 pt-md-0">

            <div class="control-filters-container" >

            <?php if($_POST['iso']):; ?>

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
                   <div class="btn btn-label-success text-nowrap actionSaveEditTranslatesContent" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></div>
                </div>
            </div>
            <?php endif; ?>

            <div class="control-filters-container-item" >
                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?>
                  </button>
                  <ul class="dropdown-menu" >
                    <li><span class="dropdown-item openModal" data-modal-id="languagesModal" ><?php echo translate("tr_cfc45c77289a8806f807b2b2f9b9655a"); ?></span></li>
                    <li><span class="dropdown-item openModal" data-modal-id="addLanguageModal" ><?php echo translate("tr_41446bef84a7e670f7f7ab7e99d18fe0"); ?></span></li>
                    <li><span class="dropdown-item actionUpdateTranslatesContent" ><?php echo translate("tr_e3301cba3a8328585a5d8da49efabae7"); ?></span></li>
                  </ul>
                </div>
            </div>

            </div>

          </div>
        </div>

        <input type="hidden" name="iso" value="<?php echo $_POST['iso']; ?>" >
        <input type="hidden" name="view" value="<?php echo $_POST['view']; ?>" >

      </form>

      <div class="card-body" >

        <?php if($_POST['iso']):; ?>

          <div class="row" >
            
            <div class="col-lg-3 col-12" >
              
              <div class="nav-align-left">

                  <ul class="nav nav-pills w-100">

                      <?php echo $template->component->translate->outContentSections($_POST['iso'],$_POST['view']); ?>

                  </ul>

              </div>

            </div>

            <div class="col-lg-9 col-12" >
              
              <form class="formTranslatesContent" >

                <input type="hidden" name="iso" value="<?php echo $_POST['iso']; ?>" >
                <input type="hidden" name="view" value="<?php echo $_POST['view']; ?>" >

                <?php echo $template->component->translate->outContent($_POST['iso'], $_POST['view']); ?>

              </form>

            </div>

          </div>

        <?php else:; ?>

          <?php echo $template->ui->wrapperInfo("dashboard-change-language"); ?>   

        <?php endif; ?>

      </div>

    </div>

    <?php if($template->pagination->totalItems):; ?>
    <div class="mt-4 text-muted" ><?php echo translate("tr_6697cca28b154d276b9b1e9795ac7230"); ?> <strong><?php echo $template->pagination->totalItems; ?></strong>, <?php echo translate("tr_932b3194a5406d1e30c4f7d91d1c161f"); ?> <strong><?php echo $template->pagination->totalPages; ?></strong></div>
    <?php endif;; ?>

    <?php echo $template->pagination->display(); ?>

  </div>

</div>

<?php echo $template->ui->tpl('translates/languages.tpl')->modal("languages", "medium"); ?>
<?php echo $template->ui->tpl('translates/add-language.tpl')->modal("addLanguage", "small"); ?>