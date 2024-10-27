<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckUserBlocked
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->header('User-Id');
        $user = User::find($userId);

        if ($user && $user->is_blocked) {
            return response()->json(['error' => 'User is blocked'], 403);
        }

        return $next($request);
    }
}
