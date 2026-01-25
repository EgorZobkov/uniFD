<?php 

$app->pagination->request($_POST);

$data = $app->model->geo_cities->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('favorite desc,name asc')->getAll('country_id=?', [$_POST['country_id']]);

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_9fb4f64da0c0ced0c83af50d633dfc09"); ?></span> </th>
        <th> <span><?php echo translate("tr_503166f739d3d3fa038de411a9c0dd4c"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $city) {

            $getRegion = $app->model->geo_regions->find("id=?", [$city['region_id']]);

            ?>

            <tr>
              <td>
                <a href="<?php echo $app->router->getRoute("dashboard-country-city-card", [$city['id']]); ?>"><?php echo $city["name"]; ?></a> 
                <div><small><?php echo $app->component->geo->outFullNameCity($city); ?></small></div>
              </td>
              <td> <?php echo $getRegion ? $getRegion->name : '-'; ?> </td>
              <td>
                <?php 
                  if($city['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success"><?php echo translate("tr_318150c53b2ec43a3ffef0f443596df1"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary"><?php echo translate("tr_17de549418a3c05ceb11239adee121a8"); ?></span>
                    <?php
                  }
                ?>
              </td>              
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light changeFavoriteCity <?php if($city['favorite']){ echo 'starActive'; } ?>" data-id="<?php echo $city['id']; ?>" >
                    <i class="ti ti-xs ti-star"></i>
                  </button>

                  <a href="<?php echo $app->router->getRoute("dashboard-country-city-card", [$city['id']]); ?>" class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light" >
                    <i class="ti ti-xs ti-eye"></i>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCity" data-id="<?php echo $city['id']; ?>" >
                    <i class="ti ti-xs ti-pencil"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCity" data-id="<?php echo $city['id']; ?>" >
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_GET['search'], "title"=>translate("tr_8dda5f598d158ecaa21dc457cd6a4916"), "subtitle"=>translate("tr_cd49d589a08b40c4c940a29bad33f428")]);
}
?>

