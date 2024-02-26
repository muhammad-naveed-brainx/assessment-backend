<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Library\ResponseMessages;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::select('id', 'name', 'email')->get();
            return $this->successResponse($users, ResponseMessages::SUCCESSFUL);
        }
        catch (\Exception $e) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User($request->validated());
            $user->password = Hash::make($request->get('password'));
            $user->save();
            return $this->successResponse($user, ResponseMessages::CREATE);
        }
        catch (\Exception $e) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Login user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::where('email', $request->get('email'))->first();
            if (!Hash::check($request->get('password'), $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['Credentials do not match.'],
                ]);
            }
            $token = $user->createToken('API')->plainTextToken;

            if ($token) {
                $data = [
                    'token' => $token,
                    'user' => $user,
                ];
                return $this->successResponse($data, ResponseMessages::CREATE);
            }
            return $this->failureResponse(ResponseMessages::MESSAGE_500);
        } catch (\Exception $exception) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * logout user
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $user = auth()->user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

            return $this->successResponse([], ResponseMessages::LOGOUT);
        } catch (\Exception $exception) {
            return $this->failureResponse(ResponseMessages::MESSAGE_500 . $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
