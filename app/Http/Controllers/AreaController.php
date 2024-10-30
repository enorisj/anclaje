<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::whereNull('deleted_at')->orderBy('created_at','desc')->get();
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

    public function update(AreaRequest $request, $id)
    {
        $area = Area::find($id);
        $area->update($request->validated());
        return response()->json([
            'flash_message' => 'Área actualizada satisfactoriamente.',
            'area' => $area
        ]);

    }

    public function destroy( $id)
    {
        $area = Area::find($id);
        $area->delete(); 
        
        return response()->json([
            'flash_message' => 'Área eliminada satisfactoriamente.'
        ]);          
    }

    public function forceDestroy ($id)
    {
        $area = Area::withoutTrashed()->find($id);
        $area->forceDelete();       
        return response()->json([
            'flash_message' => 'Área eliminado satisfactoriamente de la base de datos.'
        ]);   
    }

    public function getDeleted(){
   
        $areas_deleted = Area::onlyTrashed()->get();
        return response()->json([
            'areas' => $areas_deleted
        ]);
    
    }
    public function restore($id){
    
        $area = Area::onlyTrashed()->find($id);
        $area->restore();
        return response()->json([
            'flash_message' => 'Área ha sido restaurado.'
        ]);   
    }
}
