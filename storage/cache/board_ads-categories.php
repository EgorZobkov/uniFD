<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/ads/categories" >Категории</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-ads-categories" data-page-icon="ti-list" data-page-name="Категории объявлений" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12 col-md-12">

    <div class="container-main-content" >

    <div class="card" >

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
      <div class="input-group input-group-merge">
        <span class="input-group-text" ><i class="ti ti-search"></i></span>
        <input type="text" class="form-control formControlDefaultFilters" placeholder="Поиск..." name="search" value="<?php echo $_POST['search']; ?>" >
      </div>
  </div>
</div>

            <div class="control-filters-container-item" >
            <div class="btn-group">

                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?>
                  </button>
                  <ul class="dropdown-menu width100" >
                    <li><span class="dropdown-item openModal" data-modal-id="addCategoryModal" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span></li>
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
        <th></th>
        <th> <span>ID</span> </th>
        <th> <span>Название</span> </th>
        <th> <span>Объявлений</span> </th>
        <th> <span>Платное размещение</span> </th>
        <th> <span>Безопасная сделка</span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 sorting-container" id="sorting-container">

      
            <tr class="categories-tr-container" data-id="1" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>1</td>
              <td>Костюмы <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="1" data-parent-ids="306,329,307,308,309" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>7</td>
              <td>Нет</td>
              <td>Нет</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="1" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="1" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="categories-tr-container" data-id="2" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>2</td>
              <td>Парики <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="2" data-parent-ids="312,311,315,314,313" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>3</td>
              <td>Нет</td>
              <td>Нет</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="2" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="2" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="categories-tr-container" data-id="3" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>3</td>
              <td>Крафт <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="3" data-parent-ids="316,317,318,319" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>0</td>
              <td>Нет</td>
              <td>Нет</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="3" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="3" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="categories-tr-container" data-id="310" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>310</td>
              <td>Аксессуары <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="310" data-parent-ids="320,321,322" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>0</td>
              <td>Нет</td>
              <td>Нет</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="310" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="310" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="categories-tr-container" data-id="4" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>4</td>
              <td>Одежда и обувь <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="4" data-parent-ids="323,325,326,324,327,328" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>0</td>
              <td>Да</td>
              <td>Да</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="4" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="4" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="categories-tr-container" data-id="5" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>5</td>
              <td>Коллекции <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="5" data-parent-ids="330,332,331,333,338" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>3</td>
              <td>Нет</td>
              <td>Нет</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="5" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="5" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="categories-tr-container" data-id="7" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>7</td>
              <td>Грим и линзы <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="7" data-parent-ids="334,335" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>0</td>
              <td>Нет</td>
              <td>Нет</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="7" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="7" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="categories-tr-container" data-id="336" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>336</td>
              <td>Услуги <span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="336" data-parent-ids="337" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>0</td>
              <td>Нет</td>
              <td>Нет</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="336" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="336" >
                    <span class="ti ti-xs ti-trash"></span>
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

</div>

<?php echo $template->ui->tpl('board/categories/add-category.tpl')->modal("addCategory", "medium");; ?>
<?php echo $template->ui->tpl('board/categories/filter-template.tpl')->modal("filterTemplate", "small");; ?>