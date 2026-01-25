<?php 

$app->pagination->request($_POST);

$data = $app->model->import_export_feeds->pagination(true)->page($_POST['page'])->output($_POST['output'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span> </th>
        <th> <span><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></span> </th>      
        <th> <span><?php echo translate("tr_6cf93fc91bad2d6286b1f79fe438cba0"); ?></span> </th>   
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $feed) {
            ?>

            <tr>
              <td> <a href="<?php echo $app->component->import_export->outFeedLink($feed["filename"]); ?>" target="_blank" ><?php echo $feed["name"]; ?></a> </td>
              <td><?php echo $feed["category_id"] ? $app->component->ads_categories->categories[$feed["category_id"]]["name"] : translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?></td>
              <td><?php echo $feed["feed_format"]; ?></td>
              <td>

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFeed" data-id="<?php echo $feed['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFeed" data-id="<?php echo $feed['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "title"=>translate("tr_f930cdb2b61b19110c7579c070ce45ca"), "subtitle"=>translate("tr_931e82daa73cd07df248fcf9376c9fad")]);
}
?>