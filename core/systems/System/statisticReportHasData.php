public function statisticReportHasData($data){
    global $app;

    $count = 0;

    foreach ($data as $key => $value) {
        $count += $value->count;
    }

    return $count;

}