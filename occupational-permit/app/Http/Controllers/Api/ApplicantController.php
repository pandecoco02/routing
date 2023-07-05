<?php

namespace App\Http\Controllers\Api;

use App\Models\Applicant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Applicant as ApplicantResource;
use Symfony\Component\HttpFoundation\Response;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $applicants = [];
        if (isset($request->search)) {
            $applicants = Applicant::where('name', 'like', '%' . $request->search . '%');
        }

        $applicants = isset($request->search) && $request->search ? $applicants->paginate(10) : Applicant::paginate(10);
        return ApplicantResource::collection($applicants);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
   
            $applicant = new Applicant();

            $applicant->LastName = ucwords($request->LastName);
            $applicant->FirstName = ucwords($request->FirstName);
            $applicant->MiddleName = ucwords($request->MiddleName);
            $applicant->ExtensionName = ucwords($request->ExtensionName);
            $applicant->Age = $request->Age;
            $applicant->CivilStatus = $request->CivilStatus;
            $applicant->Photo = $request->Photo;

            $applicant->save();

            //$this->storeUserRoles($user->id, $request->user_roles);
            return response(['message' => 'Applicant has been sucessfully saved', 'data' => $applicant], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       try
       { 
            $applicant = Applicant::findOrFail($id);

            $applicant->LastName = ucwords($request->LastName);
            $applicant->FirstName = ucwords($request->FirstName);
            $applicant->MiddleName = ucwords($request->MiddleName);
            $applicant->ExtensionName = ucwords($request->ExtensionName);
            $applicant->Age = $request->Age;
            $applicant->CivilStatus = $request->CivilStatus;
            $applicant->Photo = $request->Photo;

            $applicant->update();
            return response(['message' => 'Applicant has been sucessfully saved', 'data' => $applicant], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Applicant::findOrFail($id)->delete();
        return response(['message' => 'Applicant has been sucessfully deleted'], Response::HTTP_OK);
    
    }
}
