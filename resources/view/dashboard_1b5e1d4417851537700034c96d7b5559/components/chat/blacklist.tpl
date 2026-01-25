<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_c0795423538f6f5674f82fcc778fed17"); ?></h2>
</div>

<?php
$data = $app->model->users_blacklist->sort('id desc')->getAll("from_user_id=?", [0]);

if($data){
?>

<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></span></th>
        <th><span><?php echo translate("tr_2710d4797143ef5a3368334ce709b20e"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            $user = $app->model->users->find("id=?", [$value["whom_user_id"]]);
            $channel = $app->model->chat_channels->find("id=?", [$value["channel_id"]]);

            ?>

            <tr>
              <td><a href="<?php echo $app->router->getRoute("dashboard-user-card", [$user->id]); ?>"><?php echo $app->user->name($user); ?></a></td>
              <td>
                 <?php echo $channel->name; ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteUserBlacklist" data-id="<?php echo $value['id']; ?>" >
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
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_1328064821d4e2c072bb511de34b9a1d"), "subtitle"=>null]); } ?>
