<?php

$app->pagination->request($_POST);

$data = $app->model->blog_posts->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<form class="formItemsList" >
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th>
          <input class="form-check-input actionAllCheckboxItems" type="checkbox" >          
        </th>
        <th></th>
        <th><span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span></th>
        <th><span><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th><span><?php echo translate("tr_342a6a531e4c69c287e82cfbc6dda475"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            ?>

            <tr>
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="<?php echo $value['id']; ?>" >
                </div>                
              </td>              
              <td>
                <div class="container-mini-card-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" class="image-autofocus" > </div>
              </td>
              <td>
                <div class="container-mini-text" ><?php echo $value['title']; ?></div>
              </td>
              <td>
                <?php echo $app->component->blog_categories->categories[$value["category_id"]]["name"]; ?>
              </td>
              <td>
                <?php
                  if($value['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_93928aafced6398c7dbc2ee42e498ad9"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary me-1"><?php echo translate("tr_92c541efac30251ba2be24317ebe816c"); ?></span>
                    <?php
                  }
                ?>
              </td>
              <td><?php echo $app->datetime->outDateTime($value['time_create']); ?></td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditPost" data-id="<?php echo $value['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" href="<?php echo $app->router->getRoute('dashboard-blog-post-content', [$value['id']]); ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deletePost" data-id="<?php echo $value['id']; ?>" >
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
</form>
<?php
}else{
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "search"=>$_POST['search'], "title"=>translate("tr_e67c9d758a3f7110fe9b03b040e2845b"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>