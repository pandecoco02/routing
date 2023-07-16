<?php

namespace App\Http\Controllers\Api;

use App\Models\Applicant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Applicant as ApplicantResource;
use Symfony\Component\HttpFoundation\Response;
use App\Services\FileService;
class ApplicantController extends Controller
{
    protected $file_service;
    public function __construct(
        FileService $file_service
    ) { 
        $this->file_service = $file_service; 
    }
    public function index(Request $request)
    {
        $applicants = [];
        if (isset($request->search)) {
            $applicants = Applicant::where('name', 'like', '%' . $request->search . '%');
        }

        $applicants = isset($request->search) && $request->search ? $applicants->paginate(10) : Applicant::paginate(10);
        return ApplicantResource::collection($applicants);
    }

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
            //$applicant->Photo = $request->Photo;
            if ($request->hasFile('Photo')) {
                $uploaded_image = $this->file_service->uploadImage($request->file('Photo'), config('enums.storage.clients') .'/'. $applicant->id, "CID");
                if ($uploaded_image) {
                    $applicant->Photo = $uploaded_image;
                }
            }
            $applicant->save();
            return response(['message' => 'Applicant has been sucessfully saved', 'data' => $applicant], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
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

            if ($request->hasFile('Photo')) {
                $uploaded_image = $this->file_service->uploadImage($request->file('Photo'), config('enums.storage.clients') .'/'. $applicant->id, "CID");
                if ($uploaded_image) {
                    $applicant->Photo = $uploaded_image;
                }
            }

            $applicant->update();
            return response(['message' => 'Applicant has been sucessfully saved', 'data' => $applicant], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        Applicant::findOrFail($id)->delete();
        return response(['message' => 'Applicant has been sucessfully deleted'], Response::HTTP_OK);
    
    }
}
