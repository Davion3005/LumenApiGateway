<?php

namespace App\Http\Controllers;

use App\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return list of users
     *
     * @return Response
     */
    public function index()
    {
        $user = User::all();

        return $this->validResponse($user);
    }

    /**
     * Create one new user
     *
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];
        $this->validate($request, $rules);
        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $user = User::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Obtains and shows one user
     *
     * @return Response
     */
    public function show($user)
    {
        $user = User::findOrFail($user);

        return $this->validResponse($user);
    }

    /**
     * Updates an existing user
     *
     * @return Response
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'name' => 'max:255',
            'email' => 'max:255|email|unique:users,email,' . $user,
            'password' => 'min:8|confirmed',
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($user);
        $user->fill($request->all());
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($user->isClean()) {
            return $this->errorResponse('At least one field must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();

        return $this->validResponse($user);
    }

    /**
     * Deletes an existing user
     *
     * @return Response
     */
    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $user->delete();

        return $this->validResponse($user);
    }

    /**
     * Identify existing user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return $this->validResponse($request->user());
    }
}
