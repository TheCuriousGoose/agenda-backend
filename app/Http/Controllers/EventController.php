<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $validator = $this->validateMonth($request);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $events = $this->getEventsByMonth($request->input('month'));

        return response()->json([
            'status' => 'success',
            'message' => 'Events retrieved successfully',
            'events' => $events
        ]);
    }

    public function show(Event $event)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Event retrieved successfully',
            'event' => $event->load('users')
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validateEvent($request);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $event = $this->saveEvent($request);

        return response()->json([
            'status' => 'success',
            'message' => $event->wasRecentlyCreated ? 'Event created successfully' : 'Event updated successfully',
            'event' => $event
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validator = $this->validateEvent($request);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $event = $this->saveEvent($request, $event);

        return response()->json([
            'status' => 'success',
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully'
        ]);
    }

    private function validateMonth(Request $request)
    {
        return Validator::make($request->all(), [
            'month' => 'required|date_format:Y-m',
        ]);
    }

    private function validateEvent(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'users' => 'array',
        ]);
    }

    private function validationErrorResponse($validator)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    private function getEventsByMonth($month)
    {
        $date = Carbon::parse($month);

        return Event::query()
            ->select('id', 'title', 'start_date', 'end_date')
            ->with('users:id,role')
            ->whereMonth('start_date', '=', $date->format('m'))
            ->whereYear('start_date', '=', $date->format('Y'))
            ->get();
    }

    private function saveEvent(Request $request, Event $event = null)
    {
        if ($event) {
            $event->update($request->except('users'));
        } else {
            $event = Event::create($request->except('users'));
        }

        if ($request->has('users')) {
            $event->users()->sync($request->input('users'));
        }

        return $event;
    }
}
