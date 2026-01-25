<?php

$app->pagination->request($_POST);

$data = $app->model->reviews->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort('id desc')->getAll("parent_id=? and from_user_id=?", [0,$_POST["user_id"]]);

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_458564a918c07421aad604aaeb513c54"); ?></span></th>
        <th><span><?php echo translate("tr_4a3f5e52678242b15f4e65f85ff3345c"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th><span><?php echo translate("tr_342a6a531e4c69c287e82cfbc6dda475"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            $whomUser = $app->model->users->find("id=?", [$value['whom_user_id']]);

            ?>

            <tr>
              <td>
                <div class="container-mini-card-image" > <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$whomUser->id]); ?>"><img src="<?php echo $app->storage->name($whomUser->avatar)->get(); ?>" class="image-autofocus" ></a> </div>
              </td>
              <td>
                <div class="container-mini-text" ><?php echo (string)$value['text']; ?></div>
              </td>
              <td>
                <?php
                  if($value['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_93928aafced6398c7dbc2ee42e498ad9"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary me-1"><?php echo translate("tr_13068c40c12a556c1ed7cd182ac6ab87"); ?></span>
                    <?php
                  }
                ?>
              </td>
              <td><?php echo $app->datetime->outDateTime($value['time_create']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadCardReview" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-eye"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteReview" data-id="<?php echo $value['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "title"=>translate("tr_5781a644de7a7276ce1b079f9f27fafe"), "subtitle"=>translate("tr_329cca5eed24e1d3115bf2d057634e8a")]);
}
?>