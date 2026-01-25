<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/users" >Пользователи</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-users" data-page-icon="ti-users" data-page-name="Пользователи" >
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
          <h1 class="mb-0">4</h1>
        </div>
        <small>Регистраций за сегодня</small>
      </div>
      <div class="col-12 col-md-8" >
        <div id="weeklyUsersReports" style="min-height: 210px;" ></div>
      </div>
    </div>
    <div class="border rounded p-3 mt-4">
      <div class="row">
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0">134</h3>
          </div>
          <p class="mb-0">Пользователей</p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0">134</h3>
          </div>
          <p class="mb-0">Активных</p>
        </div>
        <div class="col-12 col-sm-4">
          <div class="d-flex gap-2 align-items-center">
            <h3 class="mb-0">0</h3>
          </div>
          <p class="mb-0">Заблокированных</p>
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
          <h4 class="m-0 me-2">Регистраций за Январь</h4>
        </div>
      </div>
      <div class="card-body">
        <div id="monthUsersReports" style="min-height: 210px;"></div>
      </div>
    </div>
</div>

</div>

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

          <div class="actionsWithSelectedItems" >
            <div class="btn-group">
              <button class="btn btn-danger dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo translate("tr_5a1b889ac2877c8aac10a101e6925446"); ?> <span class="actionsWithSelectedItemsCount" ></span>
              </button>
              <ul class="dropdown-menu" >
                <li><span class="dropdown-item actionUsersMultiDelete" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span></li>
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
              <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?>
                </button>
                <ul class="dropdown-menu width100" >
                  <li><span class="dropdown-item openModal" data-modal-id="addUserModal" ><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span></li>
                </ul>
              </div>
          </div>

          </div>

        </div>
      </div>

      <?php echo $template->ui->tpl('users/control-filters.tpl')->modal("controlFilters", "small");; ?>

      </form>

      <form class="formItemsList" >
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th>
          <input class="form-check-input actionAllCheckboxItems" type="checkbox" >          
        </th>
        <th><span>Пользователь</span></th>
        <th><span>рейтинг</span></th>
        <th><span>Статус</span></th>
        <th><span>Создан</span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="150" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/08ab7e724d99cd958982b4bb3e1f94f3.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/150" class="text-body text-truncate">
                      <span class="fw-medium">Олеся Д.</span>
                                          </a>
                    <small class="text-muted">В сети</small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>22 января 2026 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/150" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="150" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="149" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/1237ec36dbf628dc052238a9bfe0e187.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/149" class="text-body text-truncate">
                      <span class="fw-medium">Александр К.</span>
                                          </a>
                    <small class="text-muted">Был: 11 минут назад</small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>22 января 2026 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/149" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="149" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="148" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/6c18252c7eef1b057aa3923ea500053f.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/148" class="text-body text-truncate">
                      <span class="fw-medium">Mion S.</span>
                                          </a>
                    <small class="text-muted">Был: 15 минут назад</small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>22 января 2026 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/148" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="148" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="147" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/054b666a68b1b9af577e2cd93c1ec5eb.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/147" class="text-body text-truncate">
                      <span class="fw-medium">Klyon N.</span>
                                          </a>
                    <small class="text-muted">Был: 17 минут назад</small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>22 января 2026 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/147" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="147" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="146" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/e438a31d61cb3fda4f673eedcc19e06b.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/146" class="text-body text-truncate">
                      <span class="fw-medium">Tujh</span>
                                          </a>
                    <small class="text-muted">Был: 18 часов назад</small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>6 января 2026 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/146" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="146" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="141" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c0c8dbb39fd2345c27bb4cf006540b58.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/141" class="text-body text-truncate">
                      <span class="fw-medium">Варвара</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/141" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="141" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="140" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/28dd67b923140105d9e6aa71d3f5fbb5.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/140" class="text-body text-truncate">
                      <span class="fw-medium">Варвара</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/140" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="140" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="138" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/1a86a90b7bcc31663cf484da4b012c77.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/138" class="text-body text-truncate">
                      <span class="fw-medium">ФанИн</span>
                                          </a>
                    <small class="text-muted">Был: 23 минуты назад</small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/138" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="138" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="137" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/8b8a73e31974b0e3a855a7a7ef79fcb8.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/137" class="text-body text-truncate">
                      <span class="fw-medium">Akirasenry</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/137" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="137" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="135" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/89d2de7ca75d64a7f5a0bd5867c2e5fc.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/135" class="text-body text-truncate">
                      <span class="fw-medium">Lammu</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/135" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="135" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="134" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/39394995b2d64a34a84b99940388a6dc.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/134" class="text-body text-truncate">
                      <span class="fw-medium">Ирина</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/134" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="134" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="132" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/6e6a17372a29b32fb11039b47d93d4be.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/132" class="text-body text-truncate">
                      <span class="fw-medium">Gypsy_wind</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/132" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="132" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="131" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/ad195625b8d66e426f82dbc7016b6d89.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/131" class="text-body text-truncate">
                      <span class="fw-medium">Serebro_zheka</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/131" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="131" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="130" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/770e3b5b52db980dab012ba02d42ba96.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/130" class="text-body text-truncate">
                      <span class="fw-medium">Anna</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/130" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="130" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="129" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/ce5bcd914b2fe151c88ab387d380af0d.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/129" class="text-body text-truncate">
                      <span class="fw-medium">Alyfisher</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/129" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="129" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="128" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/0224c32469849d7dcb14a1607019c365.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/128" class="text-body text-truncate">
                      <span class="fw-medium">Id175310767</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/128" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="128" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="127" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/51d84346114f96a25453cca4ef556335.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/127" class="text-body text-truncate">
                      <span class="fw-medium">Dany_lanov</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/127" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="127" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="126" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/0b39e78f4a712f96a5e1dc0d555276cc.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/126" class="text-body text-truncate">
                      <span class="fw-medium">Rafaellfr</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/126" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="126" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="125" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/4c2673a4aca2092a704061c5a006c5e7.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/125" class="text-body text-truncate">
                      <span class="fw-medium">Gilshadowsong</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/125" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="125" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="124" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/52073306804a42b102e28ec23649f616.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/124" class="text-body text-truncate">
                      <span class="fw-medium">Id__toruin_sai</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/124" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="124" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="123" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/af757f477b93952579b1d1a1e92d95ec.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/123" class="text-body text-truncate">
                      <span class="fw-medium">Дарья</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/123" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="123" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="122" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c6f83ced1a44252eb54c6a908651d668.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/122" class="text-body text-truncate">
                      <span class="fw-medium">Darena.bulanova</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/122" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="122" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="121" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/41196e459a04baa87c55663db419fa51.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/121" class="text-body text-truncate">
                      <span class="fw-medium">Kirika_hoshi</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/121" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="121" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="120" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/64f89f11a84287f33891e37bb0440d50.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/120" class="text-body text-truncate">
                      <span class="fw-medium">Dinbattler</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/120" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="120" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="118" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/9214e28095504f0e9fabfe44f3c88ffa.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/118" class="text-body text-truncate">
                      <span class="fw-medium">Aidenhellbert</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/118" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="118" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="117" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/163405a5b2d037826fecc3aa33276072.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/117" class="text-body text-truncate">
                      <span class="fw-medium">Id137883417</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/117" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="117" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="115" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/3a42ccb2ef74532e55356b95f3c9257c.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/115" class="text-body text-truncate">
                      <span class="fw-medium">Елена</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/115" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="115" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="112" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/697e69a740673f937cbf479556fe4e04.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/112" class="text-body text-truncate">
                      <span class="fw-medium">Furry_lis</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/112" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="112" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="110" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/813c4d5a0fce5e2772b8f7df5bb3d56a.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/110" class="text-body text-truncate">
                      <span class="fw-medium">Kara314</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/110" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="110" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="109" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/643ff20efe294285c75c3328c3ce86be.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/109" class="text-body text-truncate">
                      <span class="fw-medium">Каору</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/109" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="109" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="108" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/6ef65176dc81eeaaca32cf5fcab2b45b.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/108" class="text-body text-truncate">
                      <span class="fw-medium">Мелисса</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/108" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="108" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="107" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c797a59f2a3fff528f896fcdc9ddc9d0.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/107" class="text-body text-truncate">
                      <span class="fw-medium">Rafaell.fr</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/107" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="107" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="106" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/508d9194dab5c6e98c45ec47b8d4f9ce.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/106" class="text-body text-truncate">
                      <span class="fw-medium">Мария</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/106" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="106" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="105" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/94139dd31e6710045cc4b338ef568f2a.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/105" class="text-body text-truncate">
                      <span class="fw-medium">Кара</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/105" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="105" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="103" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/9468b27bbffabc070c916e0e62a39d5c.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/103" class="text-body text-truncate">
                      <span class="fw-medium">Carminpanda</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/103" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="103" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="102" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/584efa4b97e612c448fa1f69b4e9cb7f.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/102" class="text-body text-truncate">
                      <span class="fw-medium">Harleq</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/102" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="102" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="101" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/aac849dacdb7b96d2aade0eb5394ffb8.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/101" class="text-body text-truncate">
                      <span class="fw-medium">Госпожа Бананя</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/101" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="101" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="100" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/cb94b2e1181b9953ca810584b6a88e6f.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/100" class="text-body text-truncate">
                      <span class="fw-medium">Виктория</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/100" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="100" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="99" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/9c516f7c7b8846027920fd196a8bd747.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/99" class="text-body text-truncate">
                      <span class="fw-medium">Cat116rus</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/99" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="99" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="98" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c6096c029572ad3c019e3d31a1e799fc.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/98" class="text-body text-truncate">
                      <span class="fw-medium">Иванна</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/98" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="98" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="97" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/f828eb8681626ad868920d001bdb04b4.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/97" class="text-body text-truncate">
                      <span class="fw-medium">Маргарита</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/97" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="97" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="96" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/77a9009e3510279359138cf109b5eb7f.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/96" class="text-body text-truncate">
                      <span class="fw-medium">Id742443813</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/96" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="96" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="95" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/0d245da9a649725c6957d611c1bd41b5.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/95" class="text-body text-truncate">
                      <span class="fw-medium">A1den</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/95" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="95" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="94" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/ee3f89115da01db91ee2a774a3190ea5.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/94" class="text-body text-truncate">
                      <span class="fw-medium">Саша</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/94" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="94" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="93" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/6eb85ccf1c97bfb67056de796309c35c.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/93" class="text-body text-truncate">
                      <span class="fw-medium">Валерия</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/93" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="93" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="92" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/cbe671fc2583624b6906bd673279d157.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/92" class="text-body text-truncate">
                      <span class="fw-medium">Евгения</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/92" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="92" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="91" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/92a615c1dc5ca728676d6625b39dbf90.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/91" class="text-body text-truncate">
                      <span class="fw-medium">Yuna</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/91" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="91" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="90" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/adb44f82ad03c79991948fc1b1540a24.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/90" class="text-body text-truncate">
                      <span class="fw-medium">Latfullinadel</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/90" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="90" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="89" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/8831ed044731871737d2b31db0f49d0d.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/89" class="text-body text-truncate">
                      <span class="fw-medium">Кира Кранц</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/89" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="89" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="88" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/5f2bb7db3219f0bb66d1d783c5dd64fc.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/88" class="text-body text-truncate">
                      <span class="fw-medium">Дарья</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/88" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="88" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="86" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/5423e3589e0840e1ff9ee708c431fb72.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/86" class="text-body text-truncate">
                      <span class="fw-medium">Varobusheck</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/86" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="86" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="85" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/9a8a564aabb69880a14ad9ca81e31ecf.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/85" class="text-body text-truncate">
                      <span class="fw-medium">Howl Cipher</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/85" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="85" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="84" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c7b78414511f9637d6374a4cfe547b56.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/84" class="text-body text-truncate">
                      <span class="fw-medium">Радмила</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/84" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="84" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="83" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/0cd840561d1079e7eaf3cd67d279bbcc.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/83" class="text-body text-truncate">
                      <span class="fw-medium">Reimu</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/83" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="83" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="82" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/73dcddb4fcb8dc3b7b4130bc1b0175a4.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/82" class="text-body text-truncate">
                      <span class="fw-medium">Телль</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/82" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="82" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="81" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/2b619f4f2caf82a2b183c0530f84a91b.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/81" class="text-body text-truncate">
                      <span class="fw-medium">Rat_cerberus</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/81" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="81" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="80" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/e3f362ef67f90bf0a1b719bb7b753fe2.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/80" class="text-body text-truncate">
                      <span class="fw-medium">Ohkage</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/80" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="80" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="79" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/b6571f52cefc2e5abbb15f4622c40e67.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/79" class="text-body text-truncate">
                      <span class="fw-medium">KATE</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/79" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="79" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="78" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/57954187d7701cfc15cbd35a651e3c39.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/78" class="text-body text-truncate">
                      <span class="fw-medium">Александра</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/78" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="78" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="77" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/de4d87ccb1591959b5ada1de6abc1701.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/77" class="text-body text-truncate">
                      <span class="fw-medium">H0llyg3m</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/77" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="77" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="75" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/fe18b247c68ab0d3d44e2b19ae49b0d5.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/75" class="text-body text-truncate">
                      <span class="fw-medium">Lunarmaiden</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/75" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="75" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="74" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/fe6b02c48a868399816f62217d321978.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/74" class="text-body text-truncate">
                      <span class="fw-medium">Dekinai</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/74" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="74" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="73" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/eaf606e2142b017ad1cccf1e86fca9b8.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/73" class="text-body text-truncate">
                      <span class="fw-medium">Александра</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/73" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="73" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="72" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/981a4f82538c958fe6d66932c52a1a57.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/72" class="text-body text-truncate">
                      <span class="fw-medium">Тилли</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/72" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="72" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="71" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/fdb57ec8b238f1f432f91524e9d1b8d1.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/71" class="text-body text-truncate">
                      <span class="fw-medium">Ruruna</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/71" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="71" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="70" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/ab29b263dba676229e1bdc357c8690e0.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/70" class="text-body text-truncate">
                      <span class="fw-medium">Wasmus</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/70" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="70" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="69" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/4d070359c2d16ff3186b9d3c62f26448.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/69" class="text-body text-truncate">
                      <span class="fw-medium">Id407407844</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/69" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="69" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="68" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/ea57be6ea884ca10d3a1ce085231d815.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/68" class="text-body text-truncate">
                      <span class="fw-medium">Odincrithitandtyubit</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/68" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="68" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="67" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/5cef28adab9cda2e7a74c33e56be85fd.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/67" class="text-body text-truncate">
                      <span class="fw-medium">Nealien13</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/67" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="67" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="66" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/5a31cb403fba84cf28e15f4b8c489d95.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/66" class="text-body text-truncate">
                      <span class="fw-medium">Лиса</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/66" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="66" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="65" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/daab4dc2fefeaf1e5f51ce9c9499bca7.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/65" class="text-body text-truncate">
                      <span class="fw-medium">Oz</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/65" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="65" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="64" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/bb639997fc27e12f24730e6094b461a9.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/64" class="text-body text-truncate">
                      <span class="fw-medium">Ваньнин</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/64" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="64" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="63" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/199657d02e58d427b85091a66137e828.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/63" class="text-body text-truncate">
                      <span class="fw-medium">София</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/63" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="63" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="62" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/b418279a2a492b7410fe1ff9f16a4d56.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/62" class="text-body text-truncate">
                      <span class="fw-medium">Shinigamk</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/62" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="62" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="61" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/47edb12fdbad9af8f5de5364491d46e9.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/61" class="text-body text-truncate">
                      <span class="fw-medium">Voriikk</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/61" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="61" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="60" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/4fd6a27796b0fbb87d9530512ce8b76b.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/60" class="text-body text-truncate">
                      <span class="fw-medium">Lisyandr</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/60" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="60" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="59" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/33823156fec0a2b947e09ca0890396e7.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/59" class="text-body text-truncate">
                      <span class="fw-medium">Anais</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/59" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="59" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="58" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c88b8a8b99b41c5b330f0910f82cee4e.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/58" class="text-body text-truncate">
                      <span class="fw-medium">Gingerjoy</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/58" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="58" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="57" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/1cf15c5165852168116c36871434e33b.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/57" class="text-body text-truncate">
                      <span class="fw-medium">Sonya_blin</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/57" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="57" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="56" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/d2061d5138b8c98ace573e1e1b579468.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/56" class="text-body text-truncate">
                      <span class="fw-medium">SashaSunny</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/56" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="56" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="55" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/cc71d1d718b3972addd8c39baa298778.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/55" class="text-body text-truncate">
                      <span class="fw-medium">Zxcrinne</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/55" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="55" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="54" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/5b2db1fd5f4071a7478366e123a6241e.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/54" class="text-body text-truncate">
                      <span class="fw-medium">YukiFern</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/54" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="54" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="53" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/7a273f9096497f94293aa561e8703e8e.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/53" class="text-body text-truncate">
                      <span class="fw-medium">Алина</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/53" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="53" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="52" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/a9ea1cb9164bb89102690b1143780375.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/52" class="text-body text-truncate">
                      <span class="fw-medium">Gemelfrato</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/52" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="52" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="51" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/65e5843d1628e44993cf93781d596c50.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/51" class="text-body text-truncate">
                      <span class="fw-medium">Gesha</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/51" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="51" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="50" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/e1f5d48ff7369a65f03a7b5f5d3bc682.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/50" class="text-body text-truncate">
                      <span class="fw-medium">Ganzhenko_s</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/50" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="50" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="49" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/84e00566f7354d1fdb163b4ad3478bbb.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/49" class="text-body text-truncate">
                      <span class="fw-medium">Id50580269</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/49" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="49" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="48" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/d84f96ae3c3f7b09420aa18bfd8f7e23.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/48" class="text-body text-truncate">
                      <span class="fw-medium">Kinghall9</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/48" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="48" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="47" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/1ed1f58ae73fe6467a77208bd506e92b.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/47" class="text-body text-truncate">
                      <span class="fw-medium">Ilolapka</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/47" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="47" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="46" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/3e328f728683077f26499e602229abfa.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/46" class="text-body text-truncate">
                      <span class="fw-medium">Bowietiee</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/46" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="46" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="45" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/42045df697c91579eab5b33097bbf6e0.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/45" class="text-body text-truncate">
                      <span class="fw-medium">Софья</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/45" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="45" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="44" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/573f82dba6d2cb15dfec25390b6b7b03.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/44" class="text-body text-truncate">
                      <span class="fw-medium">Роман</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/44" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="44" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="43" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/20bb1726cb880deca25de23738358267.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/43" class="text-body text-truncate">
                      <span class="fw-medium">Станислава</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/43" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="43" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="42" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/adb53e427faf316d2c255bc4d424e1fb.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/42" class="text-body text-truncate">
                      <span class="fw-medium">Hannibalchik19191</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/42" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="42" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="41" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/a3737e92130254bc6f9cb3824f5af7ad.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/41" class="text-body text-truncate">
                      <span class="fw-medium">Kuromimio</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/41" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="41" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="40" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/0daa1c95bea891052257a22671e53b02.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/40" class="text-body text-truncate">
                      <span class="fw-medium">Connorsamuel5</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/40" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="40" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="39" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/2dae0e262e352d0d513d016c17fe6791.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/39" class="text-body text-truncate">
                      <span class="fw-medium">Arankar</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/39" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="39" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="38" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c1807b7c57e9f7d508b2b1becf9694cc.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/38" class="text-body text-truncate">
                      <span class="fw-medium">Kody_April</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/38" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="38" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="37" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/28fc8e0dbeaf51a3c4af53424ccb7e6d.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/37" class="text-body text-truncate">
                      <span class="fw-medium">Rikari_yuta</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/37" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="37" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="36" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="/storage/users/avatars/c55aadfa387368782da63d4a376a0e1f.webp" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/36" class="text-body text-truncate">
                      <span class="fw-medium">M.raskachaeva</span>
                                          </a>
                    <small class="text-muted"></small>
                  </div>
                </div>
              </td>
              <td><span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> 0</span></td>
              <td><span class="badge rounded-pill bg-label-success">Активен</span></td>
              <td>7 декабря 2025 г.</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="/dashboard_1b5e1d4417851537700034c96d7b5559/user/card/36" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="36" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            
    </tbody>
  </table>
</div>
</form>


    </div>

    <?php if($template->pagination->totalItems):; ?>
    <div class="mt-4 text-muted" ><?php echo translate("tr_6697cca28b154d276b9b1e9795ac7230"); ?> <strong><?php echo $template->pagination->totalItems; ?></strong>, <?php echo translate("tr_932b3194a5406d1e30c4f7d91d1c161f"); ?> <strong><?php echo $template->pagination->totalPages; ?></strong></div>
    <?php endif;; ?>

    <?php echo $template->pagination->display(); ?>

  </div>
</div>

<?php echo $template->ui->tpl('users/add-user.tpl')->modal("addUser", "medium");; ?>
<?php echo $template->ui->tpl('users/add-user-success.tpl')->modal("addUserSuccess", "small");; ?>