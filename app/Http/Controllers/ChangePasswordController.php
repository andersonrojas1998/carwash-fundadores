<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function update(Request $request)
    {   
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('password.change')->with('success', 'Contraseña actualizada correctamente');
    }
}