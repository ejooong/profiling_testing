<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Gallery;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view-gallery') ||
            $user->hasAnyRole(['super-admin', 'dpd-admin', 'news-writer']);
    }

    public function view(User $user, Gallery $gallery)
    {
        return $user->hasPermissionTo('view-gallery') ||
            $user->hasAnyRole(['super-admin', 'dpd-admin', 'news-writer']);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-gallery') ||
            $user->hasAnyRole(['super-admin', 'dpd-admin', 'news-writer']);
    }

    public function update(User $user, Gallery $gallery)
    {
        return $user->hasPermissionTo('edit-gallery');
    }

    public function delete(User $user, Gallery $gallery)
    {
        return $user->hasPermissionTo('delete-gallery');
    }
}
