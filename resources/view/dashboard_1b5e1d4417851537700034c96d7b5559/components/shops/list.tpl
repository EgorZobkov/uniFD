<?php

$app->pagination->request($_POST);

$data = $app->model->shops->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th><span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span></th>
        <th><span><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th><span><?php echo translate("tr_342a6a531e4c69c287e82cfbc6dda475"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            $user = $app->model->users->find("id=?", [$value['user_id']]);

            ?>

            <tr>
              <td>
                <div class="container-mini-card-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" class="image-autofocus" > </div>
              </td>
              <td>
                <a href="<?php echo $app->component->shop->linkToShopCard($value["alias"]); ?>" target="_blank" ><?php echo trimStr($value['title'], 80, true); ?></a>
              </td>              
              <td>
                <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$user->id]); ?>"><?php echo $app->user->name($user); ?></a>
              </td>
              <td>
                <span class="badge rounded-pill bg-label-<?php echo $app->component->shop->getCodeStatus($value['status'])->label; ?> me-1"><?php echo $app->component->shop->getCodeStatus($value['status'])->name; ?></span>
              </td>
              <td><?php echo $app->datetime->outDateTime($value['time_create']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditShop" data-id="<?php echo $value['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadCardShop" data-id="<?php echo $value['id']; ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteShop" data-id="<?php echo $value['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "title"=>translate("tr_7f2f538f62ba66202fb4bf6bc41ab77b"), "subtitle"=>translate("tr_4cad5dde390cc8e35127e774c54fe1c0")]);
}
?>