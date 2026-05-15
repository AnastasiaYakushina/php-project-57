<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;

class TaskStatusPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(User $user, TaskStatus $taskStatus): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TaskStatus $taskStatus): bool
    {
        return true;
    }

    public function delete(User $user, TaskStatus $taskStatus): bool
    {
        return true;
    }

    public function restore(User $user, TaskStatus $taskStatus): bool
    {
        return false;
    }

    public function forceDelete(User $user, TaskStatus $taskStatus): bool
    {
        return false;
    }
}
