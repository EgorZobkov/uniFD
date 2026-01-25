<?php

$data = $app->model->users_tariffs->sort('sorting asc')->getAll();

if($data){ 

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_61dfd483bc6befd222ca8c89129704ee"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 tariffs-sorting-container" id="tariffs-sorting-container" >

      <?php

        foreach ($data as $service) {

            $apply_count = $app->model->users->count("tariff_id=?", [$service['id']]);

            ?>

            <tr class="tariffs-tr-container" data-id="<?php echo $service['id']; ?>" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>
                <?php echo translateField($service['name']); ?>
              </td>
              <td>
                <a href="<?php echo $app->router->getRoute("dashboard-transactions"); ?>?filter[action_code]=service_tariff&filter[tariff_id]=<?php echo $service['id']; ?>"><?php echo $apply_count; ?></a>
              </td>
              <td>
                <?php
                  if($service['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary me-1"><?php echo translate("tr_17de549418a3c05ceb11239adee121a8"); ?></span>
                    <?php
                  }
                ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditServiceTariff" data-id="<?php echo $service['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteServiceTariff" data-id="<?php echo $service['id']; ?>" >
                    <i class="ti ti-xs ti-trash"></i>
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_0bd9c654c0d44b366d6a120afcc9aab7"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>