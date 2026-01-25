<?php

$app->pagination->request($_POST);

$data = $app->model->ads_filters_links->pagination(true)->page($_POST['page'])->output($_POST['output'])->search($_POST['search'])->filter($_POST['filter'])->sort('id desc')->getAll();

if($data){ 

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span>ID</span> </th>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $filter) {
            ?>

            <tr>
              <td><?php echo $filter['id']; ?></td>
              <td><a href="<?php echo $app->component->ads_filters->buildAliasesLink($filter); ?>" target="_blank" ><?php echo $filter["name"]; ?></a></td>
              <td> <?php echo $app->component->ads_categories->categories[$filter['category_id']]["name"]; ?> </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilterLink" data-id="<?php echo $filter['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilterLink" data-id="<?php echo $filter['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "title"=>translate("tr_b3c3f625dc9aa28a474a8adfab407541")]);
}
?>