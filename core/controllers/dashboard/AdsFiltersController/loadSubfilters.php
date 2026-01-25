public function loadSubfilters()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content = '';
    $sort = '';
    $level = 0;

    $filters = $this->component->ads_filters->getFilters();

    $reverseMainIds = $this->component->ads_filters->getReverseMainIds($_POST['id']);

    if($reverseMainIds){
        foreach (explode(",", $reverseMainIds) as $key => $value) {
          $level += 10;
        }
    }

    foreach ($filters["parent_id"][$_POST['id']] as $filter) {

        $loadAddPodFilter = '';
        $sort = '';

        $sub = $this->component->ads_filters->checkSubcategories($filter["id"]) ? '<span class="filters-table-open-subfilters btn btn-sm rounded-pill btn-icon btn-label-primary waves-effect waves-light loadTableSubfilters" data-id="'.$filter["id"].'" data-parent-ids="'.$this->component->ads_filters->getParentIds($filter["id"]).'" data-open="false" ><i class="ti ti-xs ti ti-arrow-down"></i></span>' : '';

        if($filter['view'] == "select" || $filter['view'] == "radiobutton"){
           $loadAddPodFilter = '
              <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddPodFilter" data-id="'.$filter['id'].'" >
                <span class="ti ti-xs ti-plus"></span>
              </button>';
        }

        if($_POST['category_id']){
            $sort = '<td> <div class="handle-sorting handle-sorting-move" ><i class="ti ti-arrows-sort"></i></div> </td>';
        }

        $content .= '
            <tr class="subfilter-item-'.$filter["id"].' filters-tr-container" data-id="'.$filter['id'].'" >
              '.$sort.'
              <td><div style="margin-left:'. $level .'px;" >'.translateField($filter["name"]).' '.$sub.'</div></td>
              <td>'.($filter["required"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td>'.($filter["default_status"] ? translate("tr_e04af96afe53462f72f39331b209a810") : translate("tr_d0cd2248137f1acac2e79777d856305e")).'</td>
              <td>'.($filter["status"] ? '<span class="badge bg-label-success me-1">'.translate("tr_318150c53b2ec43a3ffef0f443596df1").'</span>' : '<span class="badge bg-label-secondary me-1">'.translate("tr_17de549418a3c05ceb11239adee121a8").'</span>').'</td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">
                  '.$loadAddPodFilter.'

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditFilter" data-id="'.$filter['id'].'" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteFilter" data-id="'.$filter['id'].'" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

              </td>
            </tr>
        ';
    }

    return json_answer(["content"=>$content]);
}