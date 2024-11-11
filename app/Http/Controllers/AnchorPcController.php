<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnchorPCRequest;
use App\Models\Anchor_pc;
use Illuminate\Http\Request;

class AnchorPcController extends Controller
{
    public function index()
    {
        $anchor_pcs = Anchor_pc::whereNull('deleted_at')->get();
        return response()->json([
            'anchor_pcs' => $anchor_pcs
        ]);
    }
    
    public function store(AnchorPCRequest $request)
    {
        $anchor = Anchor_pc::create($request->validated());
        return response()->json([
            'message' => 'Anchor añadido satisfactoriamente.',
            'anchor' => $anchor
        ]);
    }
    
    public function show($id)
    {
        $anchor = Anchor_pc::find($id);
        return response()->json([
            'anchor_pcs' => $anchor
        ]);
    }
    public function getByNumber($number){

        $anchors_by_number = Anchor_pc::where('numero', $number)->get();
        return response()->json([
            'anchor_pc' => $anchors_by_number
        ]);
    }

    public function update(AnchorPCRequest $request, $id)
    {
        $anchor = Anchor_pc::find($id);

            $anchor->update($request->validated());
        return response()->json([
            'flash_message' => 'Anchor PC actualizado satisfactoriamente.',
            'anchor' => $anchor
        ]);         
    }

    public function destroy ($id)
    {
        $anchor = Anchor_pc::find($id);
        $anchor->delete();       
        return response()->json([
            'flash_message' => 'Anchor PC eliminado satisfactoriamente.'
        ]);   
    }
    public function forceDestroy ($id)
    {
        $anchor = Anchor_pc::withoutTrashed()->find($id);
        $anchor->forceDelete();       
        return response()->json([
            'flash_message' => 'Anchor PC eliminado satisfactoriamente de la base de datos.'
        ]);   
    }

    public function getDeleted(){
   
        $anchor_delelted = Anchor_pc::onlyTrashed()->get();
        return response()->json([
            'anchor_pcs' => $anchor_delelted
        ]);
    
    }
    public function restore($id){
    
        $anchor = Anchor_pc::onlyTrashed()->find($id);
        $anchor->restore();
        return response()->json([
            'flash_message' => 'Anchor PC ha sido restaurado.'
        ]);   
    }
    
}
