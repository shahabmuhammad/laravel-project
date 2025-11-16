<?php
    
namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
    
class RoleController extends Controller
{
    //  Display a listing of the resource.
   
     
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
    
     */
    public function index(Request $request): View
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('admin.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    // Show the form for creating a new resource.
    
    
    public function create(): View
    {
        $permission = Permission::get();
        return view('admin.roles.create',compact('permission'));
    }
    
 
    // Store a newly created resource in storage.
    
     
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $permissionsID = array_map(
            function($value) { return (int)$value; },
            $request->input('permission')
        );
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($permissionsID);
    
        return redirect()->route('admin.roles.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
   
     */
    public function show($id): View
    {
          $id = Crypt::decrypt($id);
        $role=Role::findOrFail($id);
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('admin.roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
    
     */
    public function edit($id): View
    {
     
        $id = Crypt::decrypt($id);
        $role=Role::findOrFail($id);
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('admin.roles.edit',compact('role','permission','rolePermissions'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
     
        $id = Crypt::decrypt($id);
        $role=Role::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $permissionsID = array_map(
            function($value) { return (int)$value; },
            $request->input('permission')
        );
    
        $role->syncPermissions($permissionsID);
    
        return redirect()->route('admin.roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
    
     */
    public function destroy($id): RedirectResponse
    {
     
        $id = Crypt::decrypt($id);
        $role=Role::findOrFail($id);
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('admin.roles.index')
                        ->with('success','Role deleted successfully');
    }
}