<?php

namespace App\Http\Controllers;

use App\Helpers\Helper as Helper;
use App\Models\Staff;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AutenticacionController extends Controller
{
    /* Authenticacion campos personalizados     
        1.- En auth.php
            'providers' => [
                'users' => [
                    'driver' => 'eloquent',
                    'model' => App\Models\Usuario::class,
                    'table' => 'usuario',
                ],
            ]
        2.- En Usuario.php 
            public function getAuthPassword()
            {
                return $this->contrasenia_usuario;
            }

        
        3.- En loginController (Personalizado - funcion authenticate)

        AL PARECER ESTO NO ES NECESARIO -- RECORDAR CORRER EN CONSOLA  php artisan optimize:clear
        4.-  En DatabaseUserProvider
            protected function getGenericUser($user)
            {
                if (!is_null($user)) {
                    $user = (array) $user;         
                    $user['password'] = $user['contrasenia_usuario'];
                    $user['id'] = $user['id_usuario'];
                    return new GenericUser((array) $user);
                }
            }
    */
    public function autenticar(Request $request)
    {
        $email = $request->email;
        $password = $request->contrasenia;
        $credentials = ['correo_usuario' => $email, 'password' => $password, 'vigente_usuario' => 1];


        // TOMATE #D50000
        // ROSA CHICLE #E67C73
        // MANDARINA #F4511E
        // AMARILLO HUEVO #F6BF26
        // VERDE ESMERALDA #33B679
        // VERDE MUSGO #0B8043
        // AZUL TURQUESA #039BE5
        // AZUL ARANDANO #3F51B5
        // LAVANDA #7986CB
        // MORADO INTENSO #8E24AA
        // GRAFITO #616161

        $colores = ["#D50000", "#E67C73", "#F4511E", "#F6BF26", "#33B679", "#0B8043", "#039BE5", "#3F51B5", "#7986CB", "#8E24AA", "#616161"];

        if (Auth::attempt($credentials)) {
            $staff = Staff::join('usuario', 'usuario.id_staff', 'staff.id_staff')
                ->join('perfil', 'perfil.id_perfil', 'usuario.id_perfil')
                ->where('staff.id_staff', Auth::user()->id_staff)
                ->first();
           

            $menu = Helper::CargarMenu($staff['id_perfil']);
            Session::put('staff', $staff);
         
            Session::put('menu', $menu);
            Session::put('id_staff', $staff['id_staff']);
            Session::put('nombre_staff', $staff['nombre_staff']);
            Session::put('apellido_paterno_staff', $staff['apellido_paterno_staff']);
            Session::put('apellido_materno_staff', $staff['apellido_materno_staff']);
            Session::put('correo_usuario', $staff['correo_usuario']); 
            // Session::put('background_avatar', $colores[rand(0, 10)]);
            Session::put('background_avatar', "#039BE5");

            Session::put('nombre_abreviado', substr($staff['nombre_staff'], 0, 1) . '' . substr($staff['apellido_paterno_staff'], 0, 1));

            return 'ok';
        } else {
            return response()->json([
                'success' => 'false',
                'errors'  => 'Las credenciales ingresadas son incorrectas.'
            ], 400);
        }
    }

    public function registrar(Request $request)
    {    
        $errors = [];
     
        $existingUserByEmail = Usuario::where('correo_usuario', $request->correo)->where('vigente_usuario',1)->first();
        if ($existingUserByEmail) {
            $errors['correo'] ='El correo electrónico "' . $request->correo . '" ya está en uso.';
        }
      
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }
        $max_orden = Staff::max('orden_staff');       
        $orden_staff = $max_orden + 1;

        $staff = Staff::create([
            'nombre_staff' => $request->nombres,
            'apellido_paterno_staff' =>  $request->apellido_paterno,
            'apellido_materno_staff' => $request->apellido_materno,
            'vigente_staff' => 1,
            'orden_staff'=> $orden_staff,
        ]);
        Usuario::create([
            'id_staff' => $staff['id_staff'],
            'correo_usuario' =>  $request->correo,
            'contrasenia_usuario' => Hash::make($request->contrasenia),
            'vigente_usuario' => 1
        ]);
    }

    public function cerrarSesion(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('inicio-sesion');
    }
}
