public function countChangeOptionsCity(){

    if($_GET['city_districts'] && $_GET['city_metro']){
        return count($_GET['city_districts']) + count($_GET['city_metro']);
    }elseif($_GET['city_districts']){
        return count($_GET['city_districts']);
    }elseif($_GET['city_metro']){
        return count($_GET['city_metro']);
    }

}