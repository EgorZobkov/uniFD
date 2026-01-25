<?php

$app->pagination->request($_POST);

$data = $app->model->geo_countries->pagination(true)->page($_POST['page'])->output($_POST['output'])->search($_POST['search'])->sort('status desc,name asc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_5b512ee8a59deb284ad0a6a035ba10b1"); ?></span> </th>
        <th> <span><?php echo translate("tr_d3b9e440144ac3cb320cf4627f2e0e90"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $country) {
            ?>

            <tr>
              <td> <a href="<?php echo $app->router->getRoute("dashboard-country-card", [$country['id']]); ?>"><?php echo $country["name"]; ?></a> </td>
              <td><?php echo $country["code"]; ?></td>
              <td><?php echo $country["default_status"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e"); ?></td>
              <td>
                <?php 
                  if($country['status']){
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

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCountry" data-id="<?php echo $country['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="<?php echo $app->router->getRoute("dashboard-country-card", [$country['id']]); ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCountry" data-id="<?php echo $country['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_GET['search'], "title"=>translate("tr_86eda32cc0c3421052eba5b2a1facf04"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>