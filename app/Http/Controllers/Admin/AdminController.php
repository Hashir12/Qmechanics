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
        $data['users'] = User::where('parent_id',Auth::id())->with('role')->withTrashed()->orderBy('id','desc')->paginate(5);
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

        $response = User::setAuthId(Auth::id())->createUser($request->validated());

        if ($response['status'] === 'success') {
            flash()->success('success',$response['message']);
            return redirect()->route('admin.index');
        }
        flash()->error('error',$response['message']);
        return redirect()->back();
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
        $user = User::where('parent_id',Auth::id())->where('id',$id)->first();

        if (!$user) {
            flash()->error('Error','You are not authorized to access this page');
            return redirect()->back();
        }
        return view('admin.add',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            User::updateUser($request->all(), $id);
            flash()->success('success', 'User updated successfully.');
            return redirect()->route('admin.index');

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
        flash()->success('success', 'User disabled successfully.');
        return redirect()->route('admin.index');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $user->restore();
        }
        flash()->success('success', 'User restored successfully.');
        return redirect()->route('admin.index')->with('success', 'User restored successfully.');
    }

    public function permanentDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->trashed()) {
            $user->forceDelete();
        }
        flash()->success('success', 'User deleted successfully.');
        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }
}
