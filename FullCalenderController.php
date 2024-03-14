<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Event;
use Illuminate\Http\Request;
class FullCalenderController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $today = now()->toDateString();
            $events = Event::whereHas('leave', function ($query) use ($today) {
                $query->where('Status', 'Accepted')
                    ->where('EndDate', '>=', $today);
            })->get();

            $data = $events->map(function($event) {
                return [
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end
                ];
            });

            return response()->json($data);
        }

        $this->createEventsFromLeaves();

        return view('fullcalender');
    }

    public function createEventsFromLeaves()
    {
        $acceptedLeaves = Leave::where('Status', 'Accepted')->get();

        foreach ($acceptedLeaves as $leave) {
            $existingEvent = Event::where('leave_id', $leave->id)->first();

            if (!$existingEvent) {
                Event::create([
                    'leave_id' => $leave->id,
                    'title' => (string)$leave->user->name,
                    'start' => $leave->StartDate,
                    'end' => $leave->EndDate,
                ]);
            }
        }
    }

    public function ajax(Request $request)
    {
        $leave = $request->all();

        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'leave_id' => $leave->id,
                    'title' => $leave['title'],
                    'start' => $leave['start'],
                    'end' => $leave['end'],
                ]);

                return response()->json($event);
        }
    }
}
