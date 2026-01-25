<?php

$app->pagination->request($_POST);

$data = $app->model->users_verifications->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->sort('id desc')->getAll();

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

            $user = $app->model->users->findById($value['user_id']);

            ?>
            <tr>
              <td>
                  <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$user->id]); ?>"><?php echo $app->user->name($user); ?></a>
              </td>
              <td>
                <span class="badge rounded-pill bg-label-<?php echo $app->user->getVerificationCode($value['status'])->label; ?> me-1"><?php echo $app->user->getVerificationCode($value['status'])->name; ?></span>
              </td>
              <td><?php echo $app->datetime->outDateTime($value['time_create']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <?php if($value['status'] == "awaiting_verification"){ ?>
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadCardVerification" data-id="<?php echo $value['id']; ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </button>
                  <?php } ?>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteVerification" data-id="<?php echo $value['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "title"=>translate("tr_d68e9c84a2e1289784857b6435beb680"), "subtitle"=>translate("tr_57d600a93e5960bbea584cc6ce39a32e")]);
}
?>