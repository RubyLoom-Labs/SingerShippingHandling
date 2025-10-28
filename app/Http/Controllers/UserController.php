<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends Controller
{
    // Display all users
    public function index()
    {
        try {
            $users = User::where('status', 'ACTIVE')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.user', compact('users'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load users. Please try again.');
        }
    }

    // Store new user
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'user_type' => ['required', 'in:1,2,3'],
            ], [
                'name.required' => 'The name field is required.',
                'name.max' => 'The name must not exceed 255 characters.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'password.required' => 'The password field is required.',
                'password.confirmed' => 'Password confirmation does not match.',
                'user_type.required' => 'Please select a user type.',
                'user_type.in' => 'Invalid user type selected.',
            ]);

            DB::beginTransaction();

            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'user_type' => $validated['user_type'],
                'status' => 'ACTIVE',
            ]);

            DB::commit();

            return redirect()->route('user.index')
                ->with('success', 'User created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Laravel
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('user.index')
                ->with('error', 'Failed to create user. Please try again.');
        }
    }

    // Get user data for editing
    public function edit($id)
    {
        try {
            $user = User::where('status', 'ACTIVE')->findOrFail($id);
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'User not found or has been deleted.'
            ], 404);
        }
    }

    // Update user
    public function update(Request $request, $id)
    {
        try {
            $user = User::where('status', 'ACTIVE')->findOrFail($id);

            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
                'user_type' => ['required', 'in:1,2,3'],
            ];

            $messages = [
                'name.required' => 'The name field is required.',
                'name.max' => 'The name must not exceed 255 characters.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'user_type.required' => 'Please select a user type.',
                'user_type.in' => 'Invalid user type selected.',
            ];

            // Only validate password if provided
            if ($request->filled('password')) {
                $rules['password'] = ['confirmed', Rules\Password::defaults()];
                $messages['password.confirmed'] = 'Password confirmation does not match.';
            }

            $validated = $request->validate($rules, $messages);

            DB::beginTransaction();

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->user_type = $validated['user_type'];

            if ($request->filled('password')) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            DB::commit();

            return redirect()->route('user.index')
                ->with('success', 'User updated successfully!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.index')
                ->with('error', 'User not found or has been deleted.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Laravel
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('user.index')
                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    // Delete user (soft delete by setting status to INACTIVE)
    public function destroy($id)
    {
        try {
            $user = User::where('status', 'ACTIVE')->findOrFail($id);

            // Prevent deleting yourself if you're logged in
            if (auth()->id() == $user->id) {
                return redirect()->route('user.index')
                    ->with('error', 'You cannot delete your own account.');
            }

            DB::beginTransaction();

            $user->status = 'INACTIVE';
            $user->save();

            DB::commit();

            return redirect()->route('user.index')
                ->with('success', 'User deleted successfully!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.index')
                ->with('error', 'User not found or has already been deleted.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('user.index')
                ->with('error', 'Failed to delete user. Please try again.');
        }
    }
}
