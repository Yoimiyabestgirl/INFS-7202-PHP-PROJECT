<?php namespace App\Controllers;

use App\Models\DishModel;

class MenuOrderController extends BaseController
{
    public function index()
    {
        $model = new DishModel();
        $data['dishes'] = $model->findAll();
        return view('client_order', $data);
    }
}
