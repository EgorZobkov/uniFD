<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_cfc45c77289a8806f807b2b2f9b9655a"); ?></h2>
</div>

<?php
$data = $app->model->languages->sort('id desc')->getAll();

if($data){
?>

<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span></th>
        <th><span><?php echo translate("tr_5b512ee8a59deb284ad0a6a035ba10b1"); ?></span></th>
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

                <div class="d-flex justify-content-left align-items-center" >
                  <?php if($app->storage->name($value["image"])->exist()){ ?>
                  <div class="flex-image-wrapper me-2">
                    <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" height="32" >
                  </div>
                  <?php } ?>
                  <div class="d-flex flex-column">
                    <?php echo $value['name']; ?>
                  </div>
                </div>

              </td>
              <td><?php echo $value['iso']; ?></td>
              <td>
                <?php if($value['status']){ ?>
                        <span class="badge rounded-pill bg-label-success"><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
                <?php }else{ ?>
                        <span class="badge rounded-pill bg-label-warning"><?php echo translate("tr_17de549418a3c05ceb11239adee121a8"); ?></span>
                <?php } ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditLanguage" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteLanguage" data-id="<?php echo $value['id']; ?>" >
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
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_5fa49075465973f7ecd72121765ef6c5"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]); } ?>
