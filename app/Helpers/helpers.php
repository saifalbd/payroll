
<?php

use App\Http\Resources\AuthEmployeeResource;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

function authResource(Request $request)
{
    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();
               $user->load(['company']);
        return (new AuthUserResource($user))->toArray($request);

    } else if (Auth::guard('employee')->check()) {
        $user = Auth::guard('employee')->user();
        $user->load(['company','department']);
        return (new AuthEmployeeResource($user))->toArray($request);
    }
}
