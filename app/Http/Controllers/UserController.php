<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('User/Index', [
            'users' => User::withTrashed()->where('id', '!=', auth()->user()->id)->get()
        ]);
    }

    public function block(Request $request, $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->is_blocked = (bool)($request->value ?? false);
        $user->save();

        return redirect()->back();
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->back();
    }
}
