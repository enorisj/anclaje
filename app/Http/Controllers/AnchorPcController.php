<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnchorPCRequest;
use App\Models\Anchor_pc;
use Illuminate\Http\Request;

class AnchorPcController extends Controller
{
    public function index()
    {
        $anchor_pcs = Anchor_pc::all();
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
            'anchor' => $anchor
        ]);
    }

    public function update(AnchorPCRequest $request, Anchor_pc $anchor)
    {
        $anchor->update($request->validated());
        return response()->json([
            'flash_message' => 'Anchor actualizado satisfactoriamente.',
            'anchor' => $anchor
        ]);         
    }

    public function destroy (Anchor_pc $anchor)
    {
        $anchor->delete();       
        return response()->json([
            'flash_message' => 'Anchor eliminado satisfactoriamente.'
        ]);   
    }
    public function forceDestroy (Anchor_pc $anchor)
    {
        $anchor->forceDelete();       
        return response()->json([
            'flash_message' => 'Anchor eliminado satisfactoriamente de la base de datos.'
        ]);   
    }

    public function getDeleted(){
        $anchor = Anchor_pc::onlyTrashed()->get();
        return response()->json([
            'anchor_pcs' => $anchor
        ]);
    
    }
    public function restore($id){
    
        $anchor = Anchor_pc::onlyTrashed()->find($id);
        $anchor->restore();
        return response()->json([
            'flash_message' => 'Anchorha sido restaurado.'
        ]);   
    }
    
}
