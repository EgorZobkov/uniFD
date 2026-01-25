<?php

$app->pagination->request($_POST);

$data = $app->model->search_keywords->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_67c7f630c9887ca80009c7a2dabff6cd"); ?></span> </th>
        <th> <span><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            ?>

            <tr>
              <td><?php echo $value["name"]; ?></td>
              <td><?php echo $value["category_id"] ? $app->component->ads_categories->categories[$value["category_id"]]["name"] : '-'; ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditSearchKeyword" data-id="<?php echo $value['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteSearchKeyword" data-id="<?php echo $value['id']; ?>" >
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
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "filter"=>$_POST['filter'], "title"=>translate("tr_8b7e59b1b055ad57ddede32fc327d75b"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]); } ?>