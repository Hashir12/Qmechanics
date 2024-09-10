<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['users'] = User::where('id', '!=', Auth::user()->id)->withTrashed()->paginate(10);
        return view('admin.dashboard',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            User::createUser($request->validated());
            return redirect()->route('admin.index')->with('success', 'User created successfully.');

        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.add',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            User::updateUser($request->all(), $id);
            return redirect()->route('admin.index')->with('success', 'User updated successfully.');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'User disbaled successfully.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $user->restore();
        }
        return redirect()->route('admin.index')->with('success', 'User restored successfully.');
    }

    public function permanentDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->trashed()) {
            $user->forceDelete();
        }
        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
