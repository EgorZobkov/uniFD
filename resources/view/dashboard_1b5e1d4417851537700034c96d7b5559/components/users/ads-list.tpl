<?php

$app->pagination->request($_POST);

$data->ads = $app->model->ads_data->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort('id desc')->getAll('user_id=?', [$_POST["user_id"]]);

if($data->ads){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_93928aafced6398c7dbc2ee42e498ad9"); ?></span> </th>
        <th> <span><?php echo translate("tr_1eba25e25df42c7f39caf2fabdda5b5f"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data->ads as $value) {

            $value = $app->component->ads->getDataByValue($value);

            ?>

            <tr>
              <td>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="<?php echo $value->media->images->first; ?>" class="image-autofocus rounded"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <div class="fw-medium cursor-pointer color-link loadAdCard" data-ad-id="<?php echo $value->id; ?>" ><?php echo trimStr($value->title, 40, true); ?></div>
                    <div><small class="text-muted cursor-pointer" ><?php echo trimStr($value->user->short_name, 30, true); ?></small></div>
                  </div>
                </div>
              </td>
              <td><?php echo $app->datetime->outDate($value->time_create); ?></td>
              <td>

                <?php if($value->status == 1){ ?>
                <div class="progress" style="height: 0.4rem!important;" title="<?php echo $app->datetime->outStringDiff(null,$value->time_expiration); ?>" >
                  <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $app->component->ads->outPercentCompletion($value); ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <?php }else{ ?>
                <div class="progress" style="height: 0.4rem!important;" >
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <?php } ?>

              </td>
              <td><span class="badge rounded-pill bg-label-<?php echo $app->component->ads->status($value->status)->label; ?> me-1"><?php echo $app->component->ads->status($value->status)->name; ?></span></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="<?php echo getHost(true) . '/ad/edit/' . $value->id;  ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteAd" data-id="<?php echo $value->id; ?>" >
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
  echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_abe40b620b33b61056d38cfd4f6e2ff2"), "subtitle"=>translate("tr_329cca5eed24e1d3115bf2d057634e8a")]);
}
?>