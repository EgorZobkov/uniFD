<?php

$app->pagination->request($_POST);

$data = $app->model->geo_cities_districts->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('name asc')->getAll('city_id=?', [$_POST['city_id']]);

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $district) {

            ?>

            <tr>
              <td> <?php echo $district["name"]; ?> </td>              
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCityDistrict" data-id="<?php echo $district['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCityDistrict" data-id="<?php echo $district['id']; ?>" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>

            <?php
        }

      ?>

    </tbody>
  </table>
</div>
<?php
}else{
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_GET['search'], "title"=>translate("tr_2c97797f4ea29c6bc62eac150f808ef0"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>