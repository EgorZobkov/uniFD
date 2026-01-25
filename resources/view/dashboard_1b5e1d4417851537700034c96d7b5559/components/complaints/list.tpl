<?php

$app->pagination->request($_POST);

$data = $app->model->complaints->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th><span><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th><span><?php echo translate("tr_342a6a531e4c69c287e82cfbc6dda475"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            $ad = [];

            $whomUser = $app->model->users->find("id=?", [$value['whom_user_id']]);

            if($value["item_id"]){
              $ad = $app->component->ads->getAd($value["item_id"]);
            }

            ?>

            <tr>
              <td>
                <?php if($ad){ ?>
                   <div class="container-mini-card-image" > <a href="<?php echo $app->component->ads->buildAliasesAdCard($ad); ?>" target="_blank" ><img src="<?php echo $ad->media->images->first; ?>" class="image-autofocus" ></a> </div>
                <?php }else{ ?>
                   <div class="container-mini-card-image" > <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$whomUser->id]); ?>"><img src="<?php echo $app->storage->name($whomUser->avatar)->get(); ?>" class="image-autofocus" ></a> </div>
                <?php } ?>
              </td>
              <td>
                <div class="container-mini-text" ><?php echo (string)$value['text']; ?></div>
              </td>
              <td>
                <?php
                  if($value['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_fe630d9925eeab434088f5ec6439fb33"); ?></span>
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

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadCardComplaint" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-eye"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteComplaint" data-id="<?php echo $value['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "title"=>translate("tr_63af541778fc6e5babb26b403d31f388"), "subtitle"=>translate("tr_d8be6747f855926a8a4c531023a2fe03")]);
}
?>