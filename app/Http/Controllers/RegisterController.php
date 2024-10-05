<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store(Request $request)
    {
        // Validar los campos
        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20', 'confirmed'], // 'confirmed' asegura que coincidan las contraseñas
            'terms' => ['accepted'] // Validar que se acepten los términos
        ]);

        try {
            // Encriptar la contraseña
            $attributes['password'] = bcrypt($attributes['password']);

            // Crear el usuario
            $user = User::create($attributes);
            
            // Loguear al usuario automáticamente
            Auth::login($user);

            // Mensaje flash de éxito
            session()->flash('success', 'Your account has been created.');
            
            // Redirigir al dashboard
            return redirect('/dashboard');
        } catch (Exception $e) {
            // En caso de error
            session()->flash('error', 'There was a problem creating your account. Please try again.');

            // Redirigir de vuelta a la página de registro
            return redirect()->back();
        }
    }
}
