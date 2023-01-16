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
 * Class EditController
 * @package  App\Http\Controllers\Api\Auth
 */
class EditController extends Controller
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @OA\Patch(
     *  operationId="patchAccount",
     *  summary="Edit Account",
     *  description="Edit Account",
     *  tags={"Users"},
     *  path="/api/account/patch/",
     *  @OA\RequestBody(
     *    description="Account to store",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(type="string",description="first name of User",title="name",property="first_name",example="Jozef"),
     *      @OA\Property(type="string",description="first name of User",title="name",property="last_name",example="Bugal"),
     *      @OA\Property(type="string",description="email of User",title="email",property="email"),
     *      @OA\Property(type="string",description="address of User",title="address",property="address"),
     *      @OA\Property(type="date",description="Users date of Birth",title="date_of_birth",property="date_of_birth"),
     *      @OA\Property(type="string",description="Users Phone number",title="phone",property="phone"),
     *      @OA\Property(type="string",description="Users Phone Code",title="phone_code",property="phone_code"),
     *      @OA\Property(type="string",description="Users Nationality",title="nationality",property="nationality"),
     *      @OA\Property(type="string",description="User Details",title="details",property="details")
     *     )
     *    ),
     *  ),
     *  @OA\Response(response="201",description="User patched",
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
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|min:3',
            'date_of_birth' => 'required|date',
            'phone' => 'required|min:5',
            'phone_code' => 'required|min:3',
            'nationality' => 'required|min:2',
        ]);
        $user->update($request->toArray());
        return fractal($user, new UserTransformer())->respond();
    }

}
