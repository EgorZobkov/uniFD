public function outSections(){
    global $app;

    ?>

      <li class="nav-item" >
        <a href="<?php echo $app->router->getRoute('dashboard-templates'); ?>" class="nav-link <?php if($app->router->currentRoute->name == "dashboard-templates"){ echo 'active-light'; } ?>" >
          <i class="ti ti-file me-1"></i> <?php echo translate("tr_759494086041808a9550c81060a3a6ea"); ?>
        </a>
      </li>
      <li class="nav-item" >
        <a href="<?php echo $app->router->getRoute('dashboard-template-css'); ?>" class="nav-link <?php if($app->router->currentRoute->name == "dashboard-template-css"){ echo 'active-light'; } ?>" >
          <i class="ti ti-paint me-1"></i> <?php echo translate("tr_e615eed31d3e3fcdbe9e1b50f3b30ca8"); ?>
        </a>
      </li>
      <li class="nav-item" >
        <a href="<?php echo $app->router->getRoute('dashboard-template-js'); ?>" class="nav-link <?php if($app->router->currentRoute->name == "dashboard-template-js"){ echo 'active-light'; } ?>" >
          <i class="ti ti-script me-1"></i> <?php echo translate("tr_b092423caea6bd0b943b462485c08d9f"); ?>
        </a>
      </li>

    <?php

}