<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function subirAvatar(Request $request)
    {

        if (isset($request->image)) {
            $data = $request->image;
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $path = time();
            $image_name = 'files/avatar/' . $path . '.png';
            file_put_contents($image_name, $data);
            $avatar =  Avatar::create([
                'imagen_avatar' => $path . '.png',
            ]);
            return response()->json([
                'id_avatar' => $avatar['id_avatar'],
                'imagen_avatar' => $image_name,
            ]);
        }
    }

    public function listarAvatar(Request $request)
    {
        return response()->json(Avatar::all());
    }
}
