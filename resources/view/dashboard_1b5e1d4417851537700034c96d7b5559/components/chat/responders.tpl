<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_78e125d034ef547df04c7028517e5848"); ?></h2>
</div>

<?php
$data = $app->model->chat_responders->sort('id desc')->getAll();

if($data){
?>

<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th><span><?php echo translate("tr_a0466636ebf62807f1b2674e39e15547"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {
            ?>

            <tr>
              <td><?php echo breakStr($value['name'], 100); ?></td>
              <td>
                <?php if($value['status']){ ?>
                        <span class="badge rounded-pill bg-label-success"><?php echo translate("tr_c665d401097529f7f09717764178123b"); ?></span>
                <?php }else{ ?>
                        <span class="badge rounded-pill bg-label-warning"><?php echo translate("tr_4278b38e078550f44f1795435b21aab4"); ?></span>
                <?php } ?>
              </td>
              <td>
                <?php 
                  echo $app->datetime->outDateTime($value['time_send']);
                ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">
                  <?php if(!$value['status']){ ?>
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditResponder" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>
                  <?php } ?>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteResponder" data-id="<?php echo $value['id']; ?>" >
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
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_a52d710e35d5c5f119498151cc0e35cb"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]); } ?>
