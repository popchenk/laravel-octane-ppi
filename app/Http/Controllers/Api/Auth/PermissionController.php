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
class PermissionController extends Controller
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function hasPermission(Request $request)
    {
        $user = $request->user();
        $user->can(request(['permission']));

        return fractal($user, new UserTransformer())->respond(201);
    }
}
