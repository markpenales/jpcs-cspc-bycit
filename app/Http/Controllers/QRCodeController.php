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

        $list = [
            'Kit Retrieval' => false,
        ];

        return Inertia::render(
            'Scan/Venue',
            [
                'assets' => $assets,
                'venue' => "Villafuerte Hall",
                'list' => $list,
            ]
        );
    }
    public function save(Request $request)
    {
        $registration = Registration::with('user')->find($request->input('scan'));
        abort_if(!$registration, 404, 'Registration not found!');
        $attendance = $registration->attendances()->firstOrCreate([
            'venue' => $request->input('selectedScanner'),
        ]);
        $registration = collect($registration);
        $registration->put('recorded', $attendance->wasRecentlyCreated);
        return response()->json(
            [
                'message' => 'Registration found!',
                'registration' => $registration,
            ],
            200
        );
    }

}
