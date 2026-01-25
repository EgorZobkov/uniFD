public function loadSubcategories()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content = '';
    $level = 0;

    $categories = $this->component->ads_categories->getCategories();

    $reverseMainIds = $this->component->ads_categories->getReverseMainIds($_POST['id']);

    if($reverseMainIds){
        foreach (explode(",", $reverseMainIds) as $key => $value) {
          $level += 10;
        }
    }

    foreach ($categories["parent_id"][$_POST['id']] as $category) {

        $sub = $this->component->ads_categories->checkSubcategories($category["id"]) ? '<span class="categories-table-open-subcategories btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubcategories" data-id="'.$category["id"].'" data-parent-ids="'.$this->component->ads_categories->getParentIds($category["id"]).'" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span>' : '';

        $content .= '
            <tr class="subcategory-item-'.$category["id"].' categories-tr-container" data-id="'.$category['id'].'" >
              <td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>
              <td>'.$category['id'].'</td>
              <td><div style="margin-left:'. $level .'px;" >'.translateField($category["name"]).' '.$sub.'</div></td>
              <td>'.($this->component->ads_counter->countItemsCategories($category["id"]) ?: 0).'</td>
              <td>'.($category["paid_status"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td>'.($category["secure_status"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditCategory" data-id="'.$category['id'].'" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteCategory" data-id="'.$category['id'].'" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>
        ';
    }

    return json_answer(["content"=>$content]);
}