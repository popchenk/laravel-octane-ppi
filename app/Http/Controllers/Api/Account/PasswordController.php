<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\Users\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function fractal;

/**
 * Class PasswordController
 * @package  App\Http\Controllers\Api\Auth
 */
class PasswordController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @OA\Patch(
     *  operationId="patchPassword",
     *  summary="Update Password",
     *  description="Update Password",
     *  tags={"Users"},
     *  path="/api/account/update-password/",
     *  @OA\RequestBody(
     *    description="Password to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="password",description="password of User",title="password",property="password",example="pass12Erasd"),
     *      @OA\Property(type="password",description="password confirmation of User",title="password_confirmation",property="password_confirmation",example="pass12Erasd"),
     *     )
     *    ),
     *  ),
     *  @OA\Response(response="201",description="Password patched",
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
    public function patch(Request $request)
    {
        $user = $this->model->where('id', auth('sanctum')->user()->id)->firstOrFail();
        $this->validate($request, [
            'password' => 'required|min:8|confirmed'
        ]);
        $user->update($request->toArray());
        return fractal($user, new UserTransformer())->respond();
    }

}
