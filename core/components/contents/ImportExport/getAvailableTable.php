public function getAvailableTable($table=null){
    $tables = $this->availableTables();
    return $tables[$table];
}