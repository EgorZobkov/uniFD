<?php

$app->pagination->request($_POST);

$data = $app->model->ads_filters->pagination(true)->page($_POST['page'])->output($_POST['output'])->search($_POST['search'])->filter($_POST['filter'])->sort('sorting asc')->getAll("parent_id=?", [0]);

if($data){ 

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <?php if($_POST['filter']['category_id']){ ?>
        <th></th>
        <?php } ?>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_447bd06a5389b120f71e396bb1300ec1"); ?></span> </th>
        <th> <span><?php echo translate("tr_d3b9e440144ac3cb320cf4627f2e0e90"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 sorting-container" id="sorting-container" >

      <?php

        foreach ($data as $filter) {
            ?>

            <tr class="filters-tr-container" data-id="<?php echo $filter['id']; ?>" >

              <?php if($_POST['filter']['category_id']){ ?>
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <?php } ?>

              <td><?php echo $filter["name"]; ?> <?php if($app->component->ads_filters->checkSubcategories($filter["id"])){ echo '<span class="filters-table-open-subfilters btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubfilters" data-id="'.$filter["id"].'" data-parent-ids="'.$app->component->ads_filters->getParentIds($filter["id"]).'" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span>'; } ?></td>
              <td>
                <?php echo $filter['required'] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e"); ?>
              </td>
              <td>
                <?php echo $filter['default_status'] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e"); ?>
              </td>
              <td>
                <?php
                  if($filter['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary me-1"><?php echo translate("tr_17de549418a3c05ceb11239adee121a8"); ?></span>
                    <?php
                  }
                ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <?php if($filter['view'] == "select" || $filter['view'] == "radiobutton"){ ?>
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="<?php echo $filter['id']; ?>" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>
                  <?php } ?>

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="<?php echo $filter['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="<?php echo $filter['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "title"=>translate("tr_900f536b8f57b16f6035566e2f2a29be"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>