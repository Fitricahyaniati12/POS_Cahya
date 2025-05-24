<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $req)
    {
        $user = UserModel::create($req->all());
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show(UserModel $user)
    {
        return UserModel::find($user);
    }

    // public function update(Request $request, $user_id)
    // {
    //     $user = UserModel::where('user_id', $user_id)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data not found'
    //         ], 404);
    //     }

    //     $validatedData = $request->validate([
    //         'username' => 'sometimes|required|string|max:255',
    //         'nama' => 'sometimes|required|string|max:255',
    //         'password' => 'sometimes|required|string|min:6',
    //         'level_id' => 'sometimes|required|integer'
    //     ]);

    //     // Hanya hash password jika diisi
    //     if ($request->filled('password')) {
    //         $validatedData['password'] = bcrypt($request->password);
    //     }

    //     $user->update($validatedData);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data updated successfully',
    //         'data' => $user
    //     ]);
    // }

     public function update(Request $request, $user_id)
        {
            $user = UserModel::find($user_id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $validatedData = $request->validate([
                'username' => 'sometimes|required|string|max:255|unique:m_user,username,'.$user_id.',user_id',
                'nama' => 'sometimes|required|string|max:255',
                'password' => 'sometimes|required|string|min:6',
                'level_id' => 'sometimes|required|integer|exists:m_level,level_id',
                'image' => 'sometimes|string|nullable'
            ]);

            // Hanya update password jika diisi dan belum di-hash
            if (isset($validatedData['password']) && !str_starts_with($validatedData['password'], '$2y$')) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            DB::enableQueryLog();

            $user->fill($validatedData);

            if ($user->isDirty()) {
                $user->save();

                Log::info('User Update Query:', DB::getQueryLog());

                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully',
                    'data' => $user->fresh(),
                    'changes' => $user->getChanges()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'No changes detected',
                'data' => $user,
                'debug' => [
                    'dirty_fields' => $user->getDirty(),
                    'input_data' => $validatedData
                ]
            ]);
        }

    public function destroy($user_id)
    {
        $user = UserModel::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }
}
