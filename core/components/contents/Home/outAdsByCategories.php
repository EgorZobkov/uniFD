 public function outAdsByCategories(){
    global $app;

    if($app->settings->frontend_home_slider_categories_ids){

    	foreach ($app->settings->frontend_home_slider_categories_ids as $id) {

    		$parent_ids = '';
    		
    		$category = $app->component->ads_categories->categories[$id];

    		$parent_ids = $app->component->ads_categories->joinId($id)->getParentIds($id);

    		if($parent_ids){

        		$data = $app->model->ads_data->sort("id desc limit 5")->getAll("status=? and category_id IN(".$parent_ids.")", [1]);

        		if($data){

        		shuffle($data);
        		?>

		        <div class="bold-title-and-link" >
		        	<span><?php echo translateFieldReplace($category, "name"); ?></span>
		        	<a class="btn-custom-mini button-color-scheme1" href="<?php echo $app->component->ads_categories->buildAliases($category); ?>"><?php echo translate("tr_1cc7e7972b8c9daa5e9c8e94483acc7d"); ?></a>
		        </div>

                <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" >
		        
		        	<?php
		        	foreach ($data as $item) {

		                $item = $app->component->ads->getDataByValue($item);

		                echo $app->view->setParamsComponent(['value'=>$item])->includeComponent('items/home-grid.tpl');

		        	}
		        	?>

		        </div>

        		<?php
        		}

    		}

    	}

    }


}