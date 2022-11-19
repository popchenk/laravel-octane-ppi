<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\Users\UserTransformer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function fractal;

/**
 * Class RegisterController
 * @package  App\Http\Controllers\Api\Auth
 */
class RegisterController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @OA\Post(
     *  operationId="registerUser",
     *  summary="Register new User",
     *  description="Register new User",
     *  tags={"Users"},
     *  path="/api/register",
     *  @OA\RequestBody(
     *    description="User to register",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="integer",description="id of User",title="id",property="id",example="1",readOnly="true"),
     *      @OA\Property(type="string",description="name of User",title="name",property="name",example="Jozef Bugal"),
     *      @OA\Property(type="string",description="email of User",title="email",property="email"),
     *      @OA\Property(type="password",description="password of User",title="password",property="password",example="pass12Erasd"),
     *      @OA\Property(type="password",description="password confirmation of User",title="password_confirmation",property="password_confirmation",example="pass12Erasd")
     *     )
     *    )
     *  ),
     *  @OA\Response(response="201",description="User registered",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/User"
     *      ),
     *    ),
     *  ),
     *  @OA\Response(response=422,description="Validation exception"),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = $this->model->create($request->all());
        $user->assignRole('User');
        event(new Registered($user));

        return fractal($user, new UserTransformer())->respond(201);
    }
}
