<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Lead $lead): bool
    {
        return $this->canAccess($user, $lead);
    }

    public function update(User $user, Lead $lead): bool
    {
        return $this->canAccess($user, $lead);
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $this->canAccess($user, $lead);
    }

    private function canAccess(User $user, Lead $lead): bool
    {
        return $user->role !== 'agent' || $lead->assigned_user_id === $user->id;
    }
}
