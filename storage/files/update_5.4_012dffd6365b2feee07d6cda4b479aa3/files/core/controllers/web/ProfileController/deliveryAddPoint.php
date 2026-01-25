public function deliveryAddPoint()
{

    if(intval($_POST["id"]) && $_POST["point_code"]){

        $point = $this->model->delivery_points->find("id=? and code=? and send=?", [intval($_POST["id"]),$_POST["point_code"], 1]);

        if($point){

            $this->model->users_shipping_points->delete("user_id=? and delivery_id=?", [$this->user->data->id, $point->delivery_id]);
            $this->model->users_shipping_points->insert(["user_id"=>$this->user->data->id, "address"=>$point->address, "point_id"=>intval($_POST["id"]), "point_code"=>$_POST["point_code"], "delivery_id"=>$point->delivery_id]);

        }

    }

    return json_answer(["status"=>true]);

}