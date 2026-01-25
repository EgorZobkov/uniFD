<?php

$app->pagination->request($_POST);

$data = $app->model->stories_media->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
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
                <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$user->id]); ?>"><?php echo $app->user->name($user); ?></a>
              </td>
              <td>
                <?php if($value['status'] == 0){ ?>
                    <span class="badge rounded-pill bg-label-warning me-1"><?php echo translate("tr_d9d74d385363cf3fdf9c1e62b484acca"); ?></span>
                <?php }else{ ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_93928aafced6398c7dbc2ee42e498ad9"); ?></span>
                <?php } ?>
              </td>
              <td><?php echo $app->datetime->outDateTime($value['time_create']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadStory" data-id="<?php echo $value['id']; ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteStory" data-id="<?php echo $value['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "title"=>translate("tr_753a697cf9b8c7bdd9e4aaf929c089e0"), "subtitle"=>translate("tr_6df601a7a7e5d425cecdacf9aa323f3a")]);
}
?>