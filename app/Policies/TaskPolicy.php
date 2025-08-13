<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;


// This allows only the owner of the task to update or delete it.
class TaskPolicy
{
    
    // Determine if the given task can be updated by the user.
    public function update(User $user, Task $task)
    {
        return $task->user_id === $user->id;
    }

    
    // Determine if the given task can be deleted by the user.
  
    public function delete(User $user, Task $task)
    {
        return $task->user_id === $user->id;
    }
}
