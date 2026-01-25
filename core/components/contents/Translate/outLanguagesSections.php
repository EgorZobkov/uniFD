public function outLanguagesSections($iso=null, $route=null){
    global $app;

    $getLanguages = $app->model->languages->getAll();

    if($getLanguages){

        ?>

        <div class="nav-align-top mb-4">
          <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
              <?php
                foreach ($getLanguages as $key => $value) {
                    if($iso == $value["iso"]){
                        ?>
                        <li class="nav-item"><a class="nav-link active waves-effect waves-light" href="<?php echo $route; ?>?iso=<?php echo $value["iso"]; ?>"><?php echo $value["name"]; ?></a></li>
                        <?php
                    }else{
                        ?>
                        <li class="nav-item"><a class="nav-link waves-effect waves-light" href="<?php echo $route; ?>?iso=<?php echo $value["iso"]; ?>"><?php echo $value["name"]; ?></a></li>
                        <?php                    
                    }
                }
              ?>
          </ul>
        </div>

        <?php

    }

}