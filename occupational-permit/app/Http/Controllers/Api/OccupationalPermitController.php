<?php

namespace App\Http\Controllers\Api;

use App\Models\OccupationalPermit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OccupationalPermitRequest;
use Symfony\Component\HttpFoundation\Response;
class OccupationalPermitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    public function storeOccupationalPermit(OccupationalPermitRequest $request)
    {
    try{
        
    
      } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()]);
     }
    }

    /**
     * Display the specified resource.
     */
    public function show(OccupationalPermit $occupationalPermit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OccupationalPermit $occupationalPermit)
    {
       
    }

    
    public function update(Request $request, OccupationalPermit $occupationalPermit)
    {
       
    }


    public function destroy(OccupationalPermit $occupationalPermit)
    {
        
    }
    
}
