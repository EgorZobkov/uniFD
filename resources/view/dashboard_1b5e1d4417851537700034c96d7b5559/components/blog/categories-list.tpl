<?php

$app->pagination->request($_POST);

$data = $app->model->blog_categories->pagination(true)->page($_POST['page'])->output($_POST['output'])->search($_POST['search'])->sort('sorting asc')->getAll("parent_id=?", [0]);

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th> <span>ID</span> </th>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_1ad572680550ba922398bc5c7b049ba3"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 sorting-container" id="sorting-container" >

      <?php

        foreach ($data as $category) {
            ?>

            <tr class="categories-tr-container" data-id="<?php echo $category['id']; ?>" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td><?php echo $category['id']; ?></td>
              <td><?php echo $category["name"]; ?> <?php if($app->component->blog_categories->checkSubcategories($category["id"])){ echo '<span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="'.$category["id"].'" data-parent-ids="'.$app->component->blog_categories->getParentIds($category["id"]).'" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span>'; } ?></td>
              <td><?php echo $app->component->blog->countPostsByIdCategory($category['id']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="<?php echo $category['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="<?php echo $category['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "title"=>translate("tr_b412d1762f16e2591eb838db7f0f5424"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>