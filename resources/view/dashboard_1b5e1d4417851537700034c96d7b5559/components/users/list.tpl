<?php

$app->pagination->request($_POST);

$data = $app->model->users->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<form class="formItemsList" >
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th>
          <input class="form-check-input actionAllCheckboxItems" type="checkbox" >          
        </th>
        <th><span><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></span></th>
        <th><span><?php echo translate("tr_aab146c106685b08fdc8bb362f6fc584"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th><span><?php echo translate("tr_8be108dedb061a292b9acdbf9bbaa942"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $user) {
            ?>

            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="<?php echo $user['id']; ?>" >
                </div>                
              </td>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="<?php echo $app->storage->name($user['avatar'])->get(); ?>" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$user['id']]); ?>" class="text-body text-truncate">
                      <span class="fw-medium"><?php echo $app->user->name($user,true); ?></span>
                      <?php if($user['admin']){ ?>
                      <span class="badge rounded-pill bg-label-secondary"><?php echo translateField($app->user->getRole($user['role_id'])->name); ?></span>
                      <?php } ?>
                    </a>
                    <small class="text-muted"><?php echo $app->user->labelActivity($user['time_last_activity']); ?></small>
                  </div>
                </div>
              </td>
              <td><?php echo $app->component->profile->stampCountRating($user["total_rating"]); ?></td>
              <td><span class="badge rounded-pill bg-label-<?php echo $app->user->status($user['status'])->label; ?>"><?php echo $app->user->status($user['status'])->name; ?></span></td>
              <td><?php echo $app->datetime->outDate($user['time_create']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="<?php echo $app->router->getRoute("dashboard-user-card", [$user['id']]); ?>" >
                    <span class="ti ti-xs ti-eye"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUser" data-id="<?php echo $user['id']; ?>" >
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
</form>
<?php
}else{
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "filter"=>$_POST['filter'], "title"=>translate("tr_eb25bc736f9de4c4d6832c941e5fd76e"), "subtitle"=>translate("tr_329cca5eed24e1d3115bf2d057634e8a")]);
}
?>