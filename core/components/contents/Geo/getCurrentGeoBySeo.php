public function getCurrentGeoBySeo(){
    global $app;

    if($this->getChange()){
        return (object)["name"=>translateFieldReplace($this->getChange()->data, "name"), "name_declension"=>translateFieldReplace($this->getChange()->data, "declension"), "seo_text"=>translateFieldReplace($this->getChange()->data, "seo_text")];
    }

    return (object)["name"=>translateFieldReplace($this->defaultCountry, "name"), "name_declension"=>translateFieldReplace($this->defaultCountry, "declension"), "seo_text"=>translateFieldReplace($this->defaultCountry, "seo_text")];

}