<?php

namespace App\Http\Controllers;
use App\Model\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        $data = [
            "status" => 200,
            "presentaciones" => []
        ];

        foreach ($areas as $area ) {
            array_push($data['presentaciones'], $area);
        }

        return response()->json($data);
    }
}
