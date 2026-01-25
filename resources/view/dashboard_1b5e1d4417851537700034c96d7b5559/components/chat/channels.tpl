<div class="mb-4">
  <h2 class="role-title font-weight-bold">Каналы</h2>
</div>

<?php
$data = $app->model->chat_channels->sort('id desc')->getAll();

if($data){
?>

<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th><span><?php echo translate("tr_bfedd6f472d2a3064e9bd3b8c3a0d196"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {
            ?>

            <tr>
              <td> <a href="<?php echo $app->router->getRoute("dashboard-chat-channel", [$value["id"]]); ?>"><?php echo breakStr(translateField($value['name']), 100); ?></a></td>
              <td>
                <?php if($value['status']){ ?>
                        <span class="badge rounded-pill bg-label-success"><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
                <?php }else{ ?>
                        <span class="badge rounded-pill bg-label-warning"><?php echo translate("tr_17de549418a3c05ceb11239adee121a8"); ?></span>
                <?php } ?>
              </td>
              <td>
                <?php 
                  if($value['type'] == "support"){
                    echo translate("tr_662448730e42616d253de473ba48fc61");
                  }elseif($value['type'] == "closed"){
                    echo translate("tr_0317d4178ef6c44809287e96e09193aa");
                  }elseif($value['type'] == "public"){
                    echo translate("tr_4c5280214e2b752264d2f9d347d143f0");
                  }
                ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditChannel" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <?php if(!$value['freeze']){ ?>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteChannel" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                  <?php } ?>
                </div>

              </td>
            </tr>

            <?php
        }

      ?>

    </tbody>
  </table>
</div>
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_06062dec6a78453660e9fca7dbfb3bf3"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]); } ?>
