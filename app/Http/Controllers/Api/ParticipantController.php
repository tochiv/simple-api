<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function getParticipants()
    {
        return response()->json(Participant::all());
    }

    public function getParticipant($id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json(['error' => 'Participant not found'], 404);
        }

        return response()->json($participant);
    }

    public function addParticipants(Request $request)
    {
        $participants = [];

        foreach ($request->participants as $participant) {
            $participants[] = Participant::create([
                'name' => $participant['name'],
            ]);
        }

        return response()->json($participants, 201);
    }

    public function updateParticipants(Request $request, int $id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json(['error' => 'Participant not found'], 404);
        }

        $participant->update([
            'name' => $request->name,
        ]);

        if ($request->has('task_ids')) {
            $participant->tasks()->sync($request->task_ids);
        }

        return response()->json($participant, 202);
    }

    public function deleteParticipants(int $id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json(['error' => 'Participant not found'], 404);
        }

        $participant->delete();

        return response()->json('Deleted', 200);
    }
}
