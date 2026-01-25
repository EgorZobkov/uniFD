<?php

$app->pagination->request($_POST);

$data = $app->model->promo_banners->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            ?>

            <tr>
              <td>
                <?php echo translateField($value['title']); ?>
              </td>
              <td>
                <?php
                  if($value['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary me-1"><?php echo translate("tr_5c8419ff14d1886248d9b6771d72ff15"); ?></span>
                    <?php
                  }
                ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditBanner" data-id="<?php echo $value['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteBanner" data-id="<?php echo $value['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_594d60ac50baea79b4ff852bbd2737d8"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>