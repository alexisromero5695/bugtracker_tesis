<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function listarStaff()
    {
        $staffs = Staff::where('vigente_staff', 1)->get();
        return response()->json($staffs);
    }
}
