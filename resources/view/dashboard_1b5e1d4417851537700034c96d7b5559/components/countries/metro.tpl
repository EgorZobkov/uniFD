<?php

$app->pagination->request($_POST);

$data = $app->model->geo_cities_metro->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('name asc')->getAll('city_id=? and parent_id=?', [$_POST['city_id'],0]);

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_bc8639e2d0062cb8e0df701a7dcc942a"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $metro) {

            ?>

            <tr>
              <td> <span class="metro-color-line" style="background-color:<?php echo $metro["color"]; ?>;" ></span> <?php echo $metro["name"]; ?> </td>
              <td> <?php echo $app->model->geo_cities_metro->count("parent_id=?", [$metro["id"]]); ?> </td>              
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCityMetro" data-id="<?php echo $metro['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCityMetro" data-id="<?php echo $metro['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_GET['search'], "title"=>translate("tr_b017606c83c9e909cf0c6433c1063dd2"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>