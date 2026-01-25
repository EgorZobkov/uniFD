<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/ads/filters" >Фильтры</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-ads-filters" data-page-icon="ti-filter" data-page-name="Фильтры" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12 col-md-12">

    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills flex-column flex-md-row">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo $template->router->getRoute('dashboard-ads-filters');; ?>"><?php echo translate("tr_f7ac6fc5c5a477063add9c6d0701985d"); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $template->router->getRoute('dashboard-ads-filters-links');; ?>"><?php echo translate("tr_9f58935eaf5d4cdda0f114e4f325ed0f"); ?></a>
        </li>
    </div>

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

                <select class="form-select formControlDefaultFilters selectpicker selectFilterCategoryId" data-live-search="true" title="<?php echo translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?>" name="filter[category_id]" >
                  <option value="" ><?php echo translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?></option>
                  <?php echo $template->component->ads_categories->selectedIds($_POST['filter']['category_id'])->getRecursionOptions(); ?>
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
                    <li><span class="dropdown-item openModal" data-modal-id="addFilterModal" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span></li>
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
                <th> <span>Название</span> </th>
        <th> <span>Обязательный</span> </th>
        <th> <span>По умолчанию</span> </th>
        <th> <span>Статус</span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 sorting-container" id="sorting-container" >

      
            <tr class="filters-tr-container" data-id="182" >

              
              <td>Тип одежды </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="182" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="182" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="182" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="171" >

              
              <td>Для кого </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="171" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="171" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="171" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="172" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="172" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="172" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="172" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="173" >

              
              <td>Доставка <span class="filters-table-open-subfilters btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubfilters" data-id="173" data-parent-ids="345" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="173" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="173" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="174" >

              
              <td>Тип </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="174" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="174" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="174" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="175" >

              
              <td>Тип </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="175" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="175" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="175" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="176" >

              
              <td>Тип линз <span class="filters-table-open-subfilters btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubfilters" data-id="176" data-parent-ids="346,347" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="176" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="176" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="176" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="177" >

              
              <td>С диоптриями <span class="filters-table-open-subfilters btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubfilters" data-id="177" data-parent-ids="348" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span></td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="177" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="177" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="177" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="178" >

              
              <td>Тип косметики </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="178" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="178" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="178" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="179" >

              
              <td>Тип фигурки </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="179" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="179" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="179" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="180" >

              
              <td>Тип атрибутики </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="180" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="180" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="180" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="181" >

              
              <td>Производство </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="181" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="181" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="181" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="170" >

              
              <td>Комплектация </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="170" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="170" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="170" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="183" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="183" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="183" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="183" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="184" >

              
              <td>Тип униформы </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="184" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="184" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="184" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="204" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="204" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="204" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="204" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="209" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="209" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="209" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="209" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="213" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="213" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="213" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="213" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="215" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="215" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="215" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="215" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="216" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="216" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="216" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="216" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="217" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="217" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="217" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="217" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="218" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="218" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="218" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="218" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="349" >

              
              <td>Изготовление под заказ </td>
              <td>
                Нет              </td>
              <td>
                Нет              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="349" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="349" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="349" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="107" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="107" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="107" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="107" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="97" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="97" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="97" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="97" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="98" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="98" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="98" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="98" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="99" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="99" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="99" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="99" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="100" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="100" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="100" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="100" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="101" >

              
              <td>Пол </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="101" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="101" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="101" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="102" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="102" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="102" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="102" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="103" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="103" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="103" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="103" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="104" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="104" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="104" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="104" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="105" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="105" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="105" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="105" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="106" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="106" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="106" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="106" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="96" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="96" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="96" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="96" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="108" >

              
              <td>Тип </td>
              <td>
                Да              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="108" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="108" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="108" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="126" >

              
              <td>Особенности </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="126" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="126" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="126" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="161" >

              
              <td>Состояние </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="161" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="161" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="161" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="162" >

              
              <td>Цвет </td>
              <td>
                Да              </td>
              <td>
                Нет              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="162" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="162" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="162" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="163" >

              
              <td>Длина </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="163" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="163" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="163" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="164" >

              
              <td>Тип пошива </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="164" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="164" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="164" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="165" >

              
              <td>Размер обуви </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="165" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="165" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="167" >

              
              <td>Стиль </td>
              <td>
                Нет              </td>
              <td>
                Нет              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                                    <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="167" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="167" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="167" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="168" >

              
              <td>Особенности </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="168" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="168" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr class="filters-tr-container" data-id="169" >

              
              <td>Материалы и технологии </td>
              <td>
                Нет              </td>
              <td>
                Да              </td>
              <td>
                                    <span class="badge rounded-pill bg-label-success me-1">Активен</span>
                                  </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="169" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="169" >
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

<?php echo $template->ui->tpl('board/filters/add-filter.tpl')->modal("addFilter", "medium");; ?>
<?php echo $template->ui->tpl('board/filters/add-list-items-filter.tpl')->modal("addListItemsFilter", "small");; ?>