<?php

$app->pagination->request($_POST);

$data = $app->model->chat_messages->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort('time_create desc')->getAll("parent_message_id=? and action is null", [0]);

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_b8c4e70da7bea88961184a1c1be9cb13"); ?></span></th>
        <th><span><?php echo translate("tr_3715766541542726d2733a0f8dade99b"); ?></span></th>
        <th><span><?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            $last_message = '';

            if($value['from_user_id']){
                $fromUser = $app->model->users->findById($value['from_user_id']);
                $from = '<a href="'.$app->router->getRoute("dashboard-user-card", [$fromUser->id]).'">'.$app->user->name($fromUser).'</a>';
            }else{
                $getChannel = $app->model->chat_channels->find("id=?", [$value["channel_id"]]);
                if($getChannel){
                   $from = translateFieldReplace($getChannel, "name");
                }else{
                   $from = translate("tr_80bb3f5fa5d439fb4a77cf76d869b919");
                }
            }

            if($value['whom_user_id']){
                $whomUser = $app->model->users->findById($value['whom_user_id']);
                $whom = '<a href="'.$app->router->getRoute("dashboard-user-card", [$whomUser->id]).'">'.$app->user->name($whomUser).'</a>';
            }else{
                $getChannel = $app->model->chat_channels->find("id=?", [$value["channel_id"]]);
                if($getChannel){
                   $whom = translateFieldReplace($getChannel, "name");
                }else{
                   $whom = translate("tr_80bb3f5fa5d439fb4a77cf76d869b919");
                }
            }

            if($value["text"]){
                $last_message = '<div class="container-mini-text" >'.trimStr(decrypt($value["text"]), 60, true).'</div>';
            }else{
                $last_message = '<div class="container-mini-text" >'.translate("tr_5a34e5446905d8389a6dc403bdb76b72").'</div>';
            }

            ?>

            <tr>
              <td><?php echo $from; ?> → <?php echo $whom; ?></td>
              <td><?php echo $last_message; ?></td>
              <td><?php echo $app->datetime->outDate($value['time_create']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadMessageChat" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-eye"></span>
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_649d90bb08d79914a89f7317dc6b6f0f")]);
}
?>