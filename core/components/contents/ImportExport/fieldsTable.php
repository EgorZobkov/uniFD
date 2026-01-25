public function fieldsTable($table=null){
    global $app;
    if($table == "ads"){
        return [
            "title" => translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"),
            "text" => translate("tr_38ca0af80cd7bd241500e81ba2e6efff"),
            "price" => translate("tr_682fa8dbadd54fda355b27f124938c93"),
            "old_price" => translate("tr_206948fb3ef1bd8a92285aee29a5b2f5"),
            'images' => translate("tr_67d53f4b12586c176055108451bb8355"),
            'date' => translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"),
            'address_latitude' => translate("tr_769eabf0ad4b72ec26d2e76cdb1127c5"),
            'address_longitude' => translate("tr_619e23078b3d35f39774194cc2e91db2"),
            'in_stock' => translate("tr_35044955818867ca2693fd49107c721c"),
            'link_video' => translate("tr_2bc5310f23302c852c02348e3dafe75a"),
            'external_content' => translate("tr_9bfe38a47c6f9d42c629749e32299add"),
            'partner_link' => translate("tr_6b5d775b64e9503706984360194843b8"),
            "category" => translate("tr_c95a1e2de00ee86634e177aecca00aed"),
            "city" => translate("tr_069c9cb17c0aca1e499f3a00fdeb9b3a"),
            "region" => translate("tr_503166f739d3d3fa038de411a9c0dd4c"),
            "filter" => translate("tr_2c34bf7475ce67cfad1c45882be01ca8"),
            "contact_name" => translate("tr_cd7a9cf4fadaad9d615b893741d47b7d"),
            "contact_surname" => translate("tr_505482dce5033bb6793e4931697306e0"),
            "contact_phone" => translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"),
            "contact_email" => translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"),
            "import_item_id" => translate("tr_74d8b2c5c4627a1515588820976afde7"),
        ];
    }elseif($table == "users"){
        return [
            "name" => translate("tr_d38d6d925c80a2267031f3f03d0a9070"),
            "surname" => translate("tr_a7b7df8362d60258a7208dde0a392643"),
            "email" => translate("tr_ce8ae9da5b7cd6c3df2929543a9af92d"),
            "phone" => translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"),
            "avatar" => translate("tr_6fe66ddfb771ed8cee5252576842362a"),
            "password" => translate("tr_5ebe553e01799a927b1d045924bbd4fd"),
            "balance" => translate("tr_95dcad972e98961cdb8a49897d2fc550"),
            "organization_name" => translate("tr_16c3e7e34102c34643e18ddc60acac86"),
            "import_item_id" => translate("tr_74d8b2c5c4627a1515588820976afde7"),
        ];
    }elseif($table == "blog_posts"){
        return [
            "title" => translate("tr_2e9d7991efe99efaf9cf325b6f10d8a0"),
            "content" => translate("tr_38ca0af80cd7bd241500e81ba2e6efff"),
            "category" => translate("tr_2d7e061e5eb0c367b0539ab57305c97b"),
            "image" => translate("tr_c318d6aece415f27decf21b272d94fa2"),
            "import_item_id" => translate("tr_74d8b2c5c4627a1515588820976afde7"),
        ];
    }
}