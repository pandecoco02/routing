<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\Role as ResourcesRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = [];
        if (isset($request->search)) {
            $roles = Role::where('name', 'like', '%' . $request->search . '%');
        }

        $roles = isset($request->search) && $request->search ? $roles->paginate(10) : Role::paginate(10);
        return ResourcesRole::collection(Role::paginate(10));
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = new Role();
            $role->name = ucwords($request->name);
            $role->description = $request->description;
            $role->slug = Str::slug($request->name, '-');
            $role->save();
            return response(['message' => 'Role has been sucessfully saved', 'data' => $role], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function update($id, RoleRequest $request)
    {
        try {
            $role = Role::findOrFail($id);
            $role->name = ucwords($request->name);
            $role->description = $request->description;
            $role->slug = Str::slug($request->name, '-');
            $role->update();
            return response(['message' => 'Role has been sucessfully updated', 'data' => $role], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return response(['message' => 'Role has been sucessfully updated'], Response::HTTP_OK);
    }
}