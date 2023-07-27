<?php

namespace App\Http\Controllers\Api;

use App\Models\OccupationalPermit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OccupationalPermitRequest;
use App\Http\Resources\OccupationalPermit as PermitResource;
use Symfony\Component\HttpFoundation\Response;
class OccupationalPermitController extends Controller
{

    public function index(Request $request)
    {
        $occupational_permits = [];
        if (isset($request->search)) {
            $occupational_permits = OccupationalPermit::where('name', 'like', '%' . $request->search . '%');
        }

        $occupational_permits = isset($request->search) && $request->search ? $occupational_permits->paginate(10) : OccupationalPermit::paginate(10);
        return PermitResource::collection(OccupationalPermit::paginate(10));
    }
    public function store(OccupationalPermitRequest $request)
    {
    try{
        $occupational_permits = new OccupationalPermit();
            $occupational_permits->CommunityTaxNumber = $request->CommunityTaxNumber;
            $occupational_permits->CommunityTaxFee = $request->CommunityTaxFee;
            $occupational_permits->CommunityTaxDatePaid = $request->CommunityTaxDatePaid;
            $occupational_permits->MayorsPermitNumber = $request->MayorsPermitNumber;
            $occupational_permits->MayorsPermitFee = $request->MayorsPermitFee;
            $occupational_permits->MayorsPermitDatePaid = $request->MayorsPermitDatePaid;
            $occupational_permits->HealthCardNumber = $request->HealthCardNumber;
            $occupational_permits->PoliceClearanceNo = $request->PoliceClearanceNo;
            $occupational_permits->PoliceClearanceExpiryDate = $request->PoliceClearanceExpiryDate;
            $occupational_permits->DateIssued = now()->toDateString('Ymd');
            $occupational_permits->PermitNo = $request->PermitNo;
            $occupational_permits->DateHired = $request->DateHired;
            $occupational_permits->SignatoryID = $request->SignatoryID;
            $occupational_permits->EmploymentTypeID = $request->EmploymentTypeID;
            $occupational_permits->Status = $request->Status;
            
            $occupational_permits->save();
            return response(['message' => 'Permit has been sucessfully saved', 'data' => $occupational_permits], Response::HTTP_CREATED);
    
      } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()]);
     }
    }
    
    public function update($id, OccupationalPermitRequest $request)
    {
        try{
            $occupational_permits = OccupationalPermit::findOrFail($id);
                $occupational_permits->CommunityTaxNumber = $request->CommunityTaxNumber;
                $occupational_permits->CommunityTaxFee = $request->CommunityTaxFee;
                $occupational_permits->CommunityTaxDatePaid = $request->CommunityTaxDatePaid;
                $occupational_permits->MayorsPermitNumber = $request->MayorsPermitNumber;
                $occupational_permits->MayorsPermitFee = $request->MayorsPermitFee;
                $occupational_permits->MayorsPermitDatePaid = $request->MayorsPermitDatePaid;
                $occupational_permits->HealthCardNumber = $request->HealthCardNumber;
                $occupational_permits->PoliceClearanceNo = $request->PoliceClearanceNo;
                $occupational_permits->PoliceClearanceExpiryDate = $request->PoliceClearanceExpiryDate;
                $occupational_permits->DateIssued = now()->toDateString('Ymd');
                $occupational_permits->PermitNo = $request->PermitNo;
                $occupational_permits->DateHired = $request->DateHired;
                $occupational_permits->SignatoryID = $request->SignatoryID;
                $occupational_permits->EmploymentTypeID = $request->EmploymentTypeID;
                $occupational_permits->Status = $request->Status;
                
                $occupational_permits->update();
                return response(['message' => 'Permit has been sucessfully saved', 'data' => $occupational_permits], Response::HTTP_CREATED);
        
          } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
         }
    }


    public function destroy($id)
    {
        OccupationalPermit::findOrFail($id)->delete();
        return response(['message' => 'Role has been sucessfully updated'], Response::HTTP_OK);
    }
    
}
