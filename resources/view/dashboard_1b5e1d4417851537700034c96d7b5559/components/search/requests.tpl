<?php

$app->pagination->request($_POST);

$data = $app->model->search_requests->pagination(true)->page($_POST['page'])->output($_POST['output'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_67c7f630c9887ca80009c7a2dabff6cd"); ?></span> </th>
        <th> <span><?php echo translate("tr_a12a3079e14ced46e69ba52b8a90b21a"); ?></span> </th>
        <th> <span><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></span> </th>
        <th> <span><?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?></span> </th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            if($value['user_id']){
              $user = $app->model->users->findById($value['user_id']);
            }

            ?>

            <tr>
              <td><?php echo $value["name"]; ?></td>
              <td> <a href="<?php echo $app->geo->linkToIpInfo($value["ip"]); ?>" target="_blank" ><?php echo $value["ip"]; ?></a></td>
              <?php if($user){ ?>
                <td><a href="<?php echo $app->router->getRoute("dashboard-user-card", [$value['user_id']]); ?>" ><?php echo $user->name; ?></a></td>
              <?php }else{ ?>
                <td>-</td>
              <?php } ?>
              <td><?php echo $app->datetime->outDate($value["time_create"]); ?></td>
            </tr>

            <?php
        }

      ?>

    </tbody>
  </table>
</div>
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "title"=>translate("tr_fb63b125ab5378ee8cf8edbe63d8fd90"), "subtitle"=>translate("tr_5c5726e4958a5636dc3ff591258f5826")]); } ?>