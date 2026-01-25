public function buildFeeds()
{   

    $getFeeds = $this->model->import_export_feeds->getAll("autoupdate=?", [1]);

    if($getFeeds){

        foreach ($getFeeds as $value) {

            $this->component->import_export->buildFeed($value["id"]);

        }

    }

}