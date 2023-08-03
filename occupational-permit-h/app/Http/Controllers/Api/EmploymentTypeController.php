<?php

namespace App\Http\Controllers\Api;

use App\Models\EmploymentType;
use App\Http\Requests\EmploymentTypeRequest;
use App\Http\Resources\EmploymentType as TypeResource;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmploymentTypeController extends Controller
{

    public function index(Request $request)
    {
        $types = [];
        if (isset($request->search)) {
            $types = EmploymentType::where('name', 'like', '%' . $request->search . '%');
        }

        $types = isset($request->search) && $request->search ? $types->paginate(10) : EmploymentType::paginate(10);
        return TypeResource::collection(EmploymentType::paginate(10));
    }
    
    public function store(EmploymentTypeRequest $request)
    {
        try {
            $type = new EmploymentType();
            $type->name = ucwords($request->name);
            $type->description = $request->description;
            $type->slug = Str::slug($request->name, '-');
            $type->save();
            return response(['message' => 'Type has been sucessfully saved', 'data' => $type], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }


    public function update($id, EmploymentTypeRequest $request)
    {
        try {
            $type = EmploymentType::findOrFail($id);
            $type->name = ucwords($request->name);
            $type->description = $request->description;
            $type->slug = Str::slug($request->name, '-');
            $type->update();
            return response(['message' => 'Employment type has been sucessfully updated', 'data' => $type], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    
    public function destroy($id)
    {
        EmploymentType::findOrFail($id)->delete();
        return response(['message' => 'Employment type has been sucessfully updated'], Response::HTTP_OK);
    }
}
