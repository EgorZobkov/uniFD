public function outSections(){
    global $app;

    $getSections = $this->getSections();
    
    if($getSections){
        foreach ($getSections as $value) {
           ?>

            <li class="nav-item mb-1">
              <a class="nav-link py-2 <?php if($app->router->currentRoute->name == "dashboard-settings"){ if($value["default_section"]){ echo 'active'; } }else{ if($app->router->currentRoute->name == $value["route_name"]){ echo 'active'; } } ?>" href="<?php echo $app->router->getRoute($value["route_name"]); ?>">
                <i class="ti <?php echo $value["icon"]; ?> me-2"></i>
                <span class="align-middle"><?php echo translateField($value["name"]); ?></span>
              </a>
            </li>

           <?php
        }
    }

}