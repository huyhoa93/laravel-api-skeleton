<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Utils;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserController extends BaseController
{
    protected $userRepo;

    /**
     * Create a new UserController instance
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
        $this->userRepo = $userRepo;
    }

    /**
     * Create new user
     *
     * @param UserRequest $request
     * @return void
     */
    public function register(UserRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->responseError($request->validator->errors(), 400);
        }

        try {
            $user = $this->userRepo->create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]
            );
        } catch (\Exception $e) {
            return $this->responseError(__('message.internal_server_error'), 500);
        }

        return $this->responseSuccess([], 201);
    }

    /**
     * Get a token of authenticated user
     *
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        try {
            Utils::createLogInfo('LOGING');
            if (isset($request->validator) && $request->validator->fails()) {
                return $this->responseError($request->validator->errors(), 400);
            }

            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];

            // set custom lifetime
            $token = $request->remember_me ? auth()->setTTL(1440) : auth();

            // add custom claims to token
            $token = $token->claims(['email' => $request->email])->attempt($credentials);

            if (!$token) {
                return $this->responseError(__('message.unauthorized'), 401);
            }

            return $this->responseSuccess(['token' => $token]);
        } catch (\Exception $e) {
            Utils::createLogError(__FILE__ . ': ' .  __LINE__ . ' ' . $e);
            return $this->responseError(__('message.internal_server_error'), 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return void
     */
    public function me()
    {
        return $this->responseSuccess(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout();

        return $this->responseSuccess([]);
    }

    /**
     * Refresh a token
     *
     * @return void
     */
    public function refresh()
    {
        try {
            $newToken = auth()->refresh();
            return $this->responseSuccess(['token' => $newToken]);
        } catch (\Exception $e) {
            return $this->responseError(__('message.internal_server_error'), 500);
        }
    }

    /**
     * Get all users
     *
     * @return void
     */
    public function getUsers()
    {
        try {
            $users = $this->userRepo->getUsers();
            return $this->responseSuccess($users);
        } catch (\Exception $e) {
            return $this->responseError(__('message.internal_server_error'), 500);
        }
    }
}
