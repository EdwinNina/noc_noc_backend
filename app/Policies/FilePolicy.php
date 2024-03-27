<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function canDeleteFile(User $user, File $file)
    {
        if($user->isAdmin()) return true;

        if($user->id === $file->task->user_id) return true;

        if($user->id === $file->user_id) return true;

        return false;
    }
}
