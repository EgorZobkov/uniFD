<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Models;

use App\Systems\Model;

class Settings extends Model
{

    public $alias = 'settings';
    public $table = 'uni_settings';

    public function update($value=null, $field=null){
        global $app;
        $app->db->exec("update `".$this->table."` set value=? where name=?", [$value,$field]);
    }

}