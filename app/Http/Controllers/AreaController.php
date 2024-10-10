<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('created_at','desc')->get();
        return response()->json(compact('areas'), 201);
    }
    public function store(AreaRequest $request)
    {
        $area = Area::create($request->validated());
        return response()->json([
            'flash_message' => 'Área añadida satisfactoriamente.',
            'area' => $area
        ]);
    }
    public function show($id)
    {
        $area = Area::find($id);
        
        return response()->json([
            'area' => $area
        ]);
    
    }

    public function update(AreaRequest $request, Area $area)
    {
        $area->update($request->validated());
        return response()->json([
            'flash_message' => 'Área actualizada satisfactoriamente.',
            'organizre' => $area
        ]);

    }

    public function destroy(Area $area)
    {
        $area->delete(); 
        
        return response()->json([
            'flash_message' => 'Área eliminada satisfactoriamente.'
        ]);          
    }
}
