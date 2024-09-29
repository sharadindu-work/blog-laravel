<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.user.view', ['only' => ['index', 'show']]);
        $this->middleware('can:admin.user.create', ['only' => ['create', 'store']]);
        $this->middleware('can:admin.user.edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:admin.user.delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $roles_ids =  Role::where('name', 'user')->pluck('id')->toArray();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user){
            $user->syncRoles($roles_ids);
            session()->flash('success', __('User created successfully'));
            return redirect()->route('admin.users.index');
        }else{
            session()->flash('error', __('User created unsuccessfully'));
            return redirect()->route('admin.user.index');
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
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (!empty($request->password)){
            $request['password'] = Hash::make($request->password);
            $user->update($request->only(['name', 'email', 'password']));
        }else{
            $user->update($request->only(['name', 'email']));
        }

        session()->flash('success', __('User updated successfully'));
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', __('User deleted successfully'));
        return redirect()->route('admin.users.index');
    }
}
