<?php

namespace App\Http\Controllers\Api;

use App\Domain\Repos\ParticipantRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    protected ParticipantRepositoryInterface $participantRepository;

    public function __construct(ParticipantRepositoryInterface $participantRepository){
        $this->participantRepository = $participantRepository;
    }
    public function getParticipants(){
        return response()->json($this->participantRepository->getAll());
    }

    public function getParticipant($id){
        return response()->json($this->participantRepository->get($id));
    }

    public function addParticipants(Request $request)
    {
        $data = $request->validate([
            'participants' => 'required|array|min:1',
            'participants.*.name' => 'required|string|max:255',
        ]);
        $participants = $this->participantRepository->create($data['participants']);

        return response()->json($participants, 201);
    }

    public function updateParticipants(Request $request, int $id){
        $data = $request->validate([
            'name' => 'required'
        ]);
        return response()->json(
            $this->participantRepository->update($data, $id),
            202);
    }

    public function deleteParticipants(int $id){
        return response()->json($this->participantRepository->delete($id), 200);
    }
}
