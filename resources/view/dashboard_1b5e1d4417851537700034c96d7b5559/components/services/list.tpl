<?php

$data = $app->model->ads_services->sort('sorting asc')->getAll();

if($data){ 

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 services-sorting-container" id="services-sorting-container" >

      <?php

        foreach ($data as $service) {
            ?>

            <tr class="services-tr-container" data-id="<?php echo $service['id']; ?>" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>
                <?php echo translateField($service['name']); ?>
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

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditService" data-id="<?php echo $service['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_04b282fc27170a62e9c69c03b2a0e5a8"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>