public function buildArrayGeoDefaultCountry(){
    global $app;

    return $app->component->geo->defaultCountry ? ["id"=>$app->component->geo->defaultCountry->id, "name"=>translateFieldReplace($app->component->geo->defaultCountry, "name", $_REQUEST["lang_iso"]), "declension"=>translateFieldReplace($app->component->geo->defaultCountry, "declension", $_REQUEST["lang_iso"]), "lat"=>$app->component->geo->defaultCountry->capital_latitude ?: null, "lon"=>$app->component->geo->defaultCountry->capital_longitude ?: null] : null;

}