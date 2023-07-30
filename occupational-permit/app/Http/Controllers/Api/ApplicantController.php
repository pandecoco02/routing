<?php

namespace App\Http\Controllers\Api;

use App\Models\Applicant;
use App\Http\Controllers\Controller;
use App\Models\OccupationalPermit;

use Illuminate\Http\Request;
use App\Http\Requests\ApplicantRequest;
use App\Http\Requests\OccupationalPermitRequest;
use App\Http\Resources\Applicant as ApplicantResource;
use App\Models\Signatory;
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

    public function store(ApplicantRequest $request)
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
            $this->storePermits($request, $applicant->id);
            return response(['message' => 'Applicant has been sucessfully saved', 'data' => $applicant], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function storePermits($request, $applicant_id)
    {
        try{
            $occupational_permits = new OccupationalPermit();
            $occupational_permits->Applicant_id =$applicant_id;
            $occupational_permits->CommunityTaxNumber = $request->CommunityTaxNumber;
            $occupational_permits->CommunityTaxFee = $request->CommunityTaxFee;
            $occupational_permits->CommunityTaxDatePaid = $request->CommunityTaxDatePaid;
            $occupational_permits->MayorsPermitNumber = $request->MayorsPermitNumber;
            $occupational_permits->MayorsPermitFee = $request->MayorsPermitFee;
            $occupational_permits->HealthCardNumber = $request->HealthCardNumber;
            $occupational_permits->PoliceClearanceNo = $request->PoliceClearanceNo;
            $occupational_permits->PoliceClearanceExpiryDate = $request->PoliceClearanceExpiryDate;
            $occupational_permits->DateIssued = now(); 
            $occupational_permits->DateHired = $request->DateHired;  
            $occupational_permits->EmploymentTypeID = $request->EmploymentTypeID;
            $occupational_permits->Status = $request->Status;
            $occupational_permits->save(); 
            $this->storeSignatory($occupational_permits->permit_id, $request->signatory); 
          } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
         }
    }
    public function storeSignatory($permit_id, $signatory){
        try {
            $signatory = Signatory::findOrFail($permit_id);
            $signatory->signatory()->sync($signatory);
            $signatory->update();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function update(ApplicantRequest $request, $id)
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
           // $this->storePermits($applicant->id, $request->occupational_permits);
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
