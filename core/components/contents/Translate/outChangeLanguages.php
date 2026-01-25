public function outChangeLanguages($options=[]){
    global $app;

    $class = [];

    if(!$app->settings->multi_languages_status){
        return;
    }

    if($options["align-vertical"] == "top"){
        $class[] = 'uni-dropdown-content-align-top';
    }elseif($options["align-vertical"] == "bottom"){
        $class[] = 'uni-dropdown-content-align-bottom';
    }

    if($options["align-horizontal"] == "left"){
        $class[] = 'uni-dropdown-content-align-left';
    }elseif($options["align-horizontal"] == "right"){
        $class[] = 'uni-dropdown-content-align-right';
    }

    $getLanguages = $app->model->languages->getAll("status=?", [1]);

    if($getLanguages){
        ?>
        <div class="<?php echo $options["container-class"]; ?>" >
        <div class="uni-dropdown">
          <span class="uni-dropdown-name"> <span><?php echo $app->translate->current->name; ?></span> <i class="ti ti-chevron-down"></i></span>  
          <div class="uni-dropdown-content <?php echo implode(" ", $class); ?>">
            <?php
            foreach ($getLanguages as $key => $value) {
                ?>
                <a href="<?php echo $app->translate->buildLink($value["iso"]); ?>" class="uni-dropdown-content-item" > <?php if($app->storage->name($value["image"])->exist()){  ?> <span class="uni-dropdown-content-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>"> </span> <?php } ?> <?php echo $value["name"]; ?></a>
                <?php
            }
            ?>
          </div>               
        </div>
        </div>
        <?php
    }

}