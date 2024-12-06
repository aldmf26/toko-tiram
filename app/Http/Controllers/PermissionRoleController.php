<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $data = [
            'title' => 'Permission Role',
            'roles' => $roles,
            'permissions' => $permissions
        ];
        return view('permission_role.index', $data);
    }

    public function store(Request $r)
    {
        $r->validate([
            'role' => 'required',
        ]);

        Role::create([
            'name' => $r->role,
            'guard_name' => 'web'
        ]);

        return redirect()->route('permission.index')->with(['sukses' => 'Permission Role Added']);
    }

    public function update(Request $r)
    {
        try {
            DB::beginTransaction();

            $r->validate([
                'role' => 'required',
            ]);
            $role = Role::findOrFail($r->role_id);
            $role->update(['name' => $r->role]);

            // Hapus semua permission lama sebelum mengaitkan yang baru
            $role->permissions()->detach();

            // Tambahkan permission yang di-submit
            if ($r->permission) {
                foreach ($r->permission as $p) {
                    // Periksa apakah permission memiliki nilai dan tidak null
                    if (!empty($p)) {
                        $permission = Permission::firstOrCreate(
                            ['name' => $p, 'guard_name' => 'web']
                        );

                        $role->givePermissionTo($permission);
                    }
                }
            }

            DB::commit();
            return redirect()->route('permission.index')->with('sukses', 'Permission Role Added');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('permission.index')->with(['sukses' => 'Permission Role Deleted']);
    }
}
