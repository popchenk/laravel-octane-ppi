<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\Users\UserTransformer;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use function fractal;

/**
 * @group Auth endpoints
 */
class LoginController extends Controller
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }


    /**
     * @OA\Post(
     *  operationId="loginUser",
     *  summary="Login User",
     *  description="Login User",
     *  tags={"Users"},
     *  path="/api/login",
     *  @OA\RequestBody(
     *    description="User to login",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      type="object",
     *      @OA\Property(type="string",description="email of User",title="email",property="email"),
     *      @OA\Property(type="password",description="password of User",title="password",property="password",example="pass12Erasd")
     *    )
     *    )
     *  ),
     *  @OA\Response(response="201",description="User logged in",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/User"
     *      ),
     *    ),
     *  ),
     *  @OA\Response(response=401,description="Validation exception"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return response()->json([
                'message'=> 'Invalid email or password'
            ], 401);
        }
        $user = $request->user();
        event(new Login('web',$user,false));

        return fractal($user, new UserTransformer())->respond(201);
    }
}
