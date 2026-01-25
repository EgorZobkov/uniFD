<?php 

$app->pagination->request($_POST);

$data = $app->model->import_export->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_0f3bd19339feee5b5f8c47d0fcac3044"); ?></span> </th>
        <th> <span><?php echo translate("tr_50a761a11275b70272b97775ec641e61"); ?></span> </th>
        <th> <span><?php echo translate("tr_b217306d86257f115db3addf1930bba4"); ?></span> </th>
        <th> <span><?php echo translate("tr_8d9e6898ec2351f403bf256f16aaec14"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th> <span><?php echo translate("tr_8be108dedb061a292b9acdbf9bbaa942"); ?></span> </th>        
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $task) {
            ?>

            <tr>
              <td><?php echo $task["name"]; ?></td>
              <td><?php echo $app->component->import_export->getAvailableTable($task["table"]); ?></td>
              <td>
                <?php
                  if($task["action"] == "import"){
                    echo translate("tr_d0cee49f306f8567c3eead3ff8b20265");
                  }elseif($task["action"] == "export"){
                    echo translate("tr_228fb446413f7db5925a4325fb22594a");
                  }
                ?>
              </td>
              <td><?php echo $task["errors_count"]; ?></td>
              <td><?php echo $task["uploaded_count"]; ?></td>
              <td>
                <?php
                  if($task["action"] == "export" && $task["status"] == 2){
                    echo $task["done_percent"].'%';
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-<?php echo $app->component->import_export->status($task['status'])->label; ?> me-1"><?php echo $app->component->import_export->status($task['status'])->name; ?></span>
                    <?php
                  }
                ?> 
              </td>
              <td><?php echo $app->datetime->outDate($task['time_create']); ?></td>
              <td>

                <div class="flex-column flex-md-row align-items-center text-end">

                  <?php if($task["action"] == "export" && $task["status"] == 1){ ?>

                  <a class="btn btn-icon btn-sm btn-label-success waves-effect waves-light" href="<?php echo $app->storage->name($task["filename"])->path('files-import-export')->get(); ?>" >
                    <i class="ti ti-xs ti-download"></i>
                  </a>

                  <?php } ?>

                  <?php if($task["action"] == "import"){ ?>

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="<?php echo $app->router->getRoute("dashboard-import-card", [$task['id']]); ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </a>

                  <?php } ?>

                  <?php if($task["action"] == "import" && $task["status"] != 2 && $task["status"] != 5){ ?>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteTaskImport" data-id="<?php echo $task['id']; ?>" >
                    <i class="ti ti-xs ti-trash"></i>
                  </button>

                  <?php } ?>

                  <?php if($task["action"] == "export"){ ?>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteTaskExport" data-id="<?php echo $task['id']; ?>" >
                    <i class="ti ti-xs ti-trash"></i>
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
<?php
}else{
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "search"=>$_POST['search'], "title"=>translate("tr_f930cdb2b61b19110c7579c070ce45ca"), "subtitle"=>translate("tr_931e82daa73cd07df248fcf9376c9fad")]);
}
?>