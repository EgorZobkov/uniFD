<div class="nav-align-top mb-4">
  <ul class="nav nav-pills flex-column flex-md-row">
    <li class="nav-item">
      <a class="nav-link <?php if($app->router->currentRoute->name == "dashboard-user-card"){ echo 'active'; } ?>" href="<?php echo $app->router->getRoute('dashboard-user-card', [$data->id]); ?>"><?php echo translate("tr_cecdd096144eccaeb28c4c2bc233ed63"); ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if($app->router->currentRoute->name == "dashboard-user-card-transactions"){ echo 'active'; } ?>" href="<?php echo $app->router->getRoute('dashboard-user-card-transactions', [$data->id]); ?>"><?php echo translate("tr_6f99d23532d69316b48a8bd20bf2b085"); ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if($app->router->currentRoute->name == "dashboard-user-card-deals"){ echo 'active'; } ?>" href="<?php echo $app->router->getRoute('dashboard-user-card-deals', [$data->id]); ?>"><?php echo translate("tr_9a3dc867f2fd583f53c561442ecf34b0"); ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if($app->router->currentRoute->name == "dashboard-user-card-ads"){ echo 'active'; } ?>" href="<?php echo $app->router->getRoute('dashboard-user-card-ads', [$data->id]); ?>"><?php echo translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c"); ?></a>
    </li>    
    <li class="nav-item">
      <a class="nav-link <?php if($app->router->currentRoute->name == "dashboard-user-card-reviews"){ echo 'active'; } ?>" href="<?php echo $app->router->getRoute('dashboard-user-card-reviews', [$data->id]); ?>"><?php echo translate("tr_1c3fea01a64e56bd70c233491dd537aa"); ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php if($app->router->currentRoute->name == "dashboard-user-card-security"){ echo 'active'; } ?>" href="<?php echo $app->router->getRoute('dashboard-user-card-security', [$data->id]); ?>"><?php echo translate("tr_3677ee79e51454e8da26eb578c6c4e5c"); ?></a>
    </li>
  </ul>
</div>