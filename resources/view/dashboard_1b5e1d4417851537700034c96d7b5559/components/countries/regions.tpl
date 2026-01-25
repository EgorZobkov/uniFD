<?php

$app->pagination->request($_POST);

$data = $app->model->geo_regions->pagination(true)->page($_POST['page'])->output($_POST['output'])->search($_POST['search'])->sort('name asc')->getAll('country_id=?', [$_POST["country_id"]]);

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_051672151c5f0020d1c956b22f2f996d"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $region) {
            ?>

            <tr>
              <td><?php echo $region["name"]; ?></td>
              <td><?php echo $app->model->geo_cities->count("region_id=?", [$region["id"]]); ?></td>
              <td>
                <?php 
                  if($region['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success"><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary"><?php echo translate("tr_17de549418a3c05ceb11239adee121a8"); ?></span>
                    <?php
                  }
                ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditRegion" data-id="<?php echo $region['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteRegion" data-id="<?php echo $region['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_GET['search'], "title"=>translate("tr_507968fa947a160e3038a9bd1bdf14e9"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>