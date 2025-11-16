<?php
    
namespace App\Http\Controllers\Admin;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
    
class UserController extends Controller
{
    
    public function index(Request $request): View
    {
        $data = User::latest()->paginate(5);
  
        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();

        return view('admin.users.create',compact('roles'));
    }
    
   
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('admin.users.index')
                        ->with('success','User created successfully');
    }
    
  
    public function show($id): View
    {
        $id = Crypt::decrypt($id);
        $user=User::findOrFail($id);
        $user = User::find($id);

        return view('admin.users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        
     
        $id = Crypt::decrypt($id);
        $user=User::findOrFail($id);
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('admin.users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.

     */
    public function update(Request $request, $id): RedirectResponse
    {
        $id = Crypt::decrypt($id);
        $user=User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('admin.users.index')
                        ->with('success','User updated successfully');
    }
    
   
    public function destroy($id): RedirectResponse
    {
        $id = Crypt::decrypt($id);
        $user=User::findOrFail($id);
        User::find($id)->delete();
        return redirect()->route('admin.users.index')
                        ->with('success','User deleted successfully');
    }
}