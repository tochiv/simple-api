<?php

namespace App\Domain\Repos;

use App\Models\Participant;

interface ParticipantRepositoryInterface
{
    public function get(int $id);
    public function getAll();
    public function create(array $participant);
    public function update(array $participant, $id);
    public function delete(int $id);
}
