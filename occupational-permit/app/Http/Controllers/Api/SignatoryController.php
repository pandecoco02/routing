<?php

namespace App\Http\Controllers\Api;

use App\Models\Signatory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SignatoryRequest;
use App\Http\Resources\Signatory as SignatoryResource;
use Symfony\Component\HttpFoundation\Response;

class SignatoryController extends Controller
{
    public function index(Request $request)
    {
        $signatory = [];
        if (isset($request->search)) {
            $signatory = Signatory::where('name', 'like', '%' . $request->search . '%');
        }

        $signatory = isset($request->search) && $request->search ? $signatory->paginate(10) : Signatory::paginate(10);
        return SignatoryResource::collection($signatory);
    }
    public function store(SignatoryRequest $request)
    {
        try {           
            $signatory = new Signatory();
            $signatory->LastName = ucwords($request->LastName);
            $signatory->FirstName = ucwords($request->FirstName);
            $signatory->MiddleName = ucwords($request->MiddleName);
            $signatory->ExtensionName = ucwords($request->ExtensionName);
            $signatory->Position = ucwords($request->Position);
            $signatory->DivisionName = ucwords($request->DivisionName);
            $signatory->OfficeName = ucwords($request->OfficeName);
            $signatory->City = ucwords($request->City);
            $signatory->save();
            return response(['message' => 'Signatory Officer has been sucessfully saved', 'data' => $signatory], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }



    public function update(SignatoryRequest $request, $id)
    {
        try {   
            $signatory = Signatory::findOrFail($id);        
            $signatory = new Signatory();
            $signatory->LastName = ucwords($request->LastName);
            $signatory->FirstName = ucwords($request->FirstName);
            $signatory->MiddleName = ucwords($request->MiddleName);
            $signatory->ExtensionName = ucwords($request->ExtensionName);
            $signatory->Position = ucwords($request->Position);
            $signatory->DivisionName = ucwords($request->DivisionName);
            $signatory->OfficeName = ucwords($request->OfficeName);
            $signatory->City = ucwords($request->City);
            $signatory->update();
            return response(['message' => 'Signatory Officer has been sucessfully updated', 'data' => $signatory], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        
    }

    public function destroy($id)
    {
        Signatory::findOrFail($id)->delete();
        return response(['message' => 'Signatory Officer has been sucessfully deleted'], Response::HTTP_OK);
    }
}
