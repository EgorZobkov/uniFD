  public function outSystemMenu(){
      global $app;

      $getMenu = $app->model->system_menu->sort("sorting asc")->getAll("parent_id=?", [0]);

      foreach ($getMenu as $key => $value) {

        if($value["submenu"] == 0){

          if(isset($app->user->data->privilegesList[$value["route_id"]]["view"]) || $app->user->data->role->chief){
          ?>
            <li class="menu-item <?php if($app->router->currentRoute->route_id == $value["route_id"]){ echo 'active'; } ?>">
              <a href="<?php echo $app->router->getRoute($value["route_alias"]); ?>" class="menu-link">
                <?php echo $value["icon"]; ?>
                <div><?php echo translateField($value["name"]); ?></div>
              </a>
            </li>
          <?php
          }

        }else{

          $getSubmenu = $app->model->system_menu->sort("sorting asc")->getAll("parent_id=?", [$value["id"]]);
          $getItemByRoute = $app->model->system_menu->find("route_id=? and parent_id=?", [$app->router->currentRoute->route_id, $value["id"]]);

          if(!$app->user->data->role->chief){
              if($getSubmenu){
                  foreach ($getSubmenu as $subkey => $subvalue) {
                      if(!$app->user->data->privilegesList[$subvalue["route_id"]]["view"]){
                          unset($getSubmenu[$subkey]);
                      }
                  }
              }
          }

          if($getSubmenu){

             ?>

              <li class="menu-item <?php if($getItemByRoute){ echo 'open'; } ?>">
                <a class="menu-link menu-toggle">
                  <?php echo $value["icon"]; ?>
                  <div><?php echo translateField($value["name"]); ?></div>
                </a>
                <ul class="menu-sub">

                  <?php
                     foreach ($getSubmenu as $subvalue) {
                        ?>

                        <li class="menu-item <?php if($app->router->currentRoute->route_id == $subvalue["route_id"]){ echo 'active'; } ?>">
                          <a href="<?php echo $app->router->getRoute($subvalue["route_alias"]); ?>" class="menu-link">
                            <div><?php echo translateField($subvalue["name"]); ?></div>
                          </a>
                        </li>

                        <?php
                     }
                  ?>

                </ul>
              </li>
                               
             <?php

          }
             
        }

      }        

  }