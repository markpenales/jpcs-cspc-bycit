<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function scan(Registration $register){
        dd($register);
    }
}
