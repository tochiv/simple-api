<?php

namespace App\Repos;

use App\Domain\Repos\ParticipantRepositoryInterface;
use App\Models\Participant;

class ParticipantRepository implements ParticipantRepositoryInterface
{
    public function get(int $id)
    {
        return Participant::with('tasks')->find($id);
    }

    public function getAll()
    {
        return Participant::all();
    }

    public function create(array $participants): array
    {
        $createdParticipants = [];
        foreach ($participants as $participant)
        {
            $createdParticipants[] = Participant::create($participant);
        }

        return $createdParticipants;
    }

    public function update(array $updateParticipant, $id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return null;
        }

        $participant->update($updateParticipant);

        $participant->tasks()->sync($participant);

        return $participant;
    }

    public function delete(int $id): bool
    {
        $participant = Participant::with('tasks')->find($id);

        if (!$participant)
        {
            return false;
        }

        return $participant->delete();
    }
}
