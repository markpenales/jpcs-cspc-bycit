<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QRCodeController extends Controller
{
    public function index()
    {
        $assets = [
            'background' => asset('assets/background.svg'),
        ];
        $links = [
            'villafuerte_hall' => route('scan.villafuerte_hall'),
            'pearl' => route('scan.pearl'),
            'ctde' => route('scan.ctde'),
            'auditorium' => route('scan.auditorium'),
        ];
        return Inertia::render('Scan/Index', ['assets' => $assets, 'links' => $links]);
    }
    public function scan(Registration $register)
    {
        dd($register);
    }

    public function villafuerteHall()
    {
        $assets = [
            'background' => asset('assets/background.svg'),
        ];
        dd('hi');
    }

    public function pearl()
    {
        $assets = [
            'background' => asset('assets/background.svg'),
        ];
        dd('hi');
    }

    public function ctde()
    {
        $assets = [
            'background' => asset('assets/background.svg'),
        ];
        dd('hi');
    }

    public function auditorium()
    {
        $assets = [
            'background' => asset('assets/background.svg'),
        ];
        dd('hi');
    }

}
