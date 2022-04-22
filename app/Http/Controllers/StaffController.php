<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function GetStaffs()
    {
        $staffs = Staff::where('current', 1)->get();
        return response()->json($staffs);
    }
}
