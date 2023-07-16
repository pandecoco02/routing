<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = [];
        if (isset($request->search)) {
            $users = User::where('name', 'like', '%' . $request->search . '%');
        }

        $users = isset($request->search) && $request->search ? $users->paginate(10) : User::paginate(10);
        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        try {
            $default_password = "*1234#";
   
            $user = new User();
            $user->password = bcrypt($default_password);
            $user->email = $request->email;
            $user->first_name = ucwords($request->first_name);
            $user->last_name = ucwords($request->last_name);
            $user->middle_name = ucwords($request->middle_name);
            $user->extension_name = ucwords($request->extension_name);
            $user->address = $request->address;
            $user->contact_no = $request->contact_no;
            $user->position = $request->position;
            $user->work_place = $request->work_place;
            $user->save();

            $this->storeUserRoles($user->id, $request->user_roles);
            return response(['message' => 'User has been sucessfully saved', 'data' => $user], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function storeUserRoles($user_id, $user_roles)
    {
        try {
            $user = User::findOrFail($user_id);
            $user->roles()->sync($user_roles);
            $user->update();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->email = $request->email;
            $user->first_name = ucwords($request->first_name);
            $user->last_name = ucwords($request->last_name);
            $user->middle_name = ucwords($request->middle_name);
            $user->extension_name = ucwords($request->extension_name);
            $user->address = $request->address;
            $user->contact_no = $request->contact_no;
            $user->position = $request->position;
            $user->work_place = $request->work_place;
            $this->storeUserRoles($user->id, $request->user_roles);
            $user->update();
            return response(['message' => 'User has been sucessfully updated', 'data' => $user], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response(['message' => 'User has been sucessfully deleted'], Response::HTTP_OK);
    }
}
