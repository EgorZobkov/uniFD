public function outMainCategoriesOptions($category_id=0){

    if($this->getMainCategories()){

          foreach ($this->getMainCategories() as $key => $value) {
            if($category_id == $value["id"]){
                ?>
                <option value="<?php echo $value["id"]; ?>" selected="" ><?php echo translateFieldReplace($value, "name"); ?></option>
                <?php
            }else{
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo translateFieldReplace($value, "name"); ?></option>
                <?php
            }
          }

    }

}