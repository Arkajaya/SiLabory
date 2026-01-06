<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = User::orderBy('created_at', 'desc');
        if (! empty($q)) {
            $query->where(function($b) use ($q) {
                $b->where('name', 'like', '%' . $q . '%')
                  ->orWhere('email', 'like', '%' . $q . '%')
                  ->orWhere('nim', 'like', '%' . $q . '%');
            });
        }

        $users = $query->paginate(6);

        if ($request->ajax()) {
            return view('users._rows', compact('users'))->render();
        }

        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nim' => 'nullable|string|unique:users,nim',
            'study_program' => 'nullable|string|max:255',
            'card_identity_photo' => 'nullable|image|max:5120',
            'role' => 'nullable|string|exists:roles,name',
        ]);

        if ($request->hasFile('card_identity_photo')) {
            $validated['card_identity_photo'] = $request->file('card_identity_photo')->store('users', 'public');
        }

        $user = User::create($validated);
        if (! empty($validated['role'])) {
            $user->assignRole($validated['role']);
        }

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'nim' => 'nullable|string|unique:users,nim,' . $user->id,
            'study_program' => 'nullable|string|max:255',
            'card_identity_photo' => 'nullable|image|max:5120',
            'role' => 'nullable|string|exists:roles,name',
        ]);

        if ($request->hasFile('card_identity_photo')) {
            $validated['card_identity_photo'] = $request->file('card_identity_photo')->store('users', 'public');
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);
        if (array_key_exists('role', $validated)) {
            if (! empty($validated['role'])) {
                $user->syncRoles([$validated['role']]);
            } else {
                $user->syncRoles([]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function detail(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        return view('users.detail', compact('user'));
    }
}
