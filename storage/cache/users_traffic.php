<?php class_exists('App\Systems\View') or exit; ?>


<div class="row mb-4" >
  
  <div class="col-lg-9 col-md-9 order-md-1 order-2" >
    
    <div class="breadcrumbs-links" > 
      Дашборд / <a href="/dashboard_1b5e1d4417851537700034c96d7b5559/users/traffic" >Трафик в текущем времени</a>    </div>

  </div>

  <div class="col-lg-3 col-md-3 order-1 text-end" >
    
        <div class="gap-3">
      <button class="btn rounded-pill btn-icon btn-label-danger waves-effect template-add-to-favorites" data-route-name="dashboard-users-traffic" data-page-icon="ti-users-group" data-page-name="Трафик в текущем времени" >
                  <span class="ti ti-heart-plus"></span>
              </button>
    </div>
    
  </div>

</div>



<div class="row g-4">

  <div class="col-12">

    <?php if(!$template->settings->frontend_scripts):; ?>
    <div class="alert alert-warning d-flex align-items-center mt-0 mb-3" role="alert">
      <?php echo translate("tr_e9e5d2f9c1d8cdb2bb88de79362ca60b"); ?> <a href="<?php echo $template->router->getRoute("dashboard-settings-systems"); ?>/#systems-scripts"><?php echo translate("tr_b4484a2be5cc2633b3d1ce1d2585af3c"); ?></a>
    </div>
    <?php endif; ?>

    <div class="card">

      <form class="formControlFilters" >

      <div class="card-header flex-column flex-md-row">
        <div class="text-end pt-3 pt-md-0">

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

      </form>

      
<div class="table-responsive">
  <table class="table border-top">
    <thead>
      <tr>
        <th class="text-truncate"> <span>Браузер</span> </th>
        <th class="text-truncate"> <span>Устройство</span> </th>
        <th class="text-truncate"> <span>URI</span> </th>
        <th class="text-truncate"> <span>referer</span> </th>
        <th class="text-truncate"> <span>IP</span> </th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

    
        <tr>
          <td class="text-truncate">
            <span class="fw-medium">Yandex</span>
          </td>
          <td class="text-truncate">Компьютер</td>
          <td class="text-truncate"><a href="https://my-fd.ru//" target="_blank" >https://my-fd.ru//</a></td>
          <td class="text-truncate">
            <a href="https://uni-api.com.ru/disguiseLink.php?link=https%3A%2F%2Fmy-fd.ru%2F" target="_blank" >https://my-fd.ru/</a>          </td>
          <td class="text-truncate"><a href="https://uni-api.com.ru/ipcheck.php?ip=79.127.211.212" target="_blank" >79.127.211.212</a></td>
        </tr>

       
        <tr>
          <td class="text-truncate">
            <span class="fw-medium">Safari</span>
          </td>
          <td class="text-truncate">Смартфон</td>
          <td class="text-truncate"><a href="https://my-fd.ru//auth" target="_blank" >https://my-fd.ru//auth</a></td>
          <td class="text-truncate">
            -          </td>
          <td class="text-truncate"><a href="https://uni-api.com.ru/ipcheck.php?ip=43.135.145.77" target="_blank" >43.135.145.77</a></td>
        </tr>

       
        <tr>
          <td class="text-truncate">
            <span class="fw-medium">-</span>
          </td>
          <td class="text-truncate">Компьютер</td>
          <td class="text-truncate"><a href="https://my-fd.ru//" target="_blank" >https://my-fd.ru//</a></td>
          <td class="text-truncate">
            -          </td>
          <td class="text-truncate"><a href="https://uni-api.com.ru/ipcheck.php?ip=66.132.153.125" target="_blank" >66.132.153.125</a></td>
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