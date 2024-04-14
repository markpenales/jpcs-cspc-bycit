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

    private function getVenueData($venueName)
    {
        $assets = [
            'background' => asset('assets/background.svg'),
        ];

        $list = [
            'Kit Retrieval' => false,
        ];

        if ($venueName === "Pearl" || $venueName === "CTDE" || $venueName === "Auditorium") {
            $list = [

                'Attendance (1st Day - PM)' => false,
                'Attendance (2nd Day - AM)' => false,
                'Attendance (2nd Day - PM)' => false,
                'Lunch (1st Day)' => false,
                'Lunch (2nd Day)' => false,
                'Snack (1st Day - PM)' => false,
                'Snack (2nd Day - AM)' => false,
                'Snack (2nd Day - PM)' => false,



            ];
        }

        return [
            'assets' => $assets,
            'venue' => $venueName,
            'list' => $list,
        ];
    }

    public function villafuerteHall()
    {
        return Inertia::render('Scan/Venue', $this->getVenueData("Villafuerte Hall"));
    }

    public function pearl()
    {
        return Inertia::render('Scan/Venue', $this->getVenueData("Pearl"));
    }

    public function ctde()
    {
        return Inertia::render('Scan/Venue', $this->getVenueData("CTDE"));
    }

    public function auditorium()
    {
        return Inertia::render('Scan/Venue', $this->getVenueData("Auditorium"));
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
