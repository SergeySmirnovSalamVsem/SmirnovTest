<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // 1.1 Регистрация пользователя
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|alpha|unique:users',
            'name' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return response()->json($user, 201);
    }

    // 1.2 Получение информации об авторизованном пользователе
    public function show(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    // 1.3 Редактирование данных пользователя
    public function update(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'username' => 'sometimes|alpha|unique:users,username,' . $user->id,
            'name' => 'sometimes|string',
        ]);

        $user->update($validated);

        return response()->json($user);
    }

    // 1.4 Удаление пользователя
    public function destroy(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Вспомогательный метод для получения текущего пользователя по ID из заголовка
    private function getAuthenticatedUser(Request $request)
    {
        $userId = $request->header('User-Id');
        return User::find($userId);
    }
}
