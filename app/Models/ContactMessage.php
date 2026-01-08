<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use SoftDeletes;

    protected $table = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent',
        'attachments',
        'replied_at',
        'reply_message',
        'replied_by',
    ];

    protected $casts = [
        'attachments' => 'array',
        'replied_at' => 'datetime',
    ];

    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function markAsRead()
    {
        $this->update(['status' => 'read']);
    }

    public function markAsReplied($replyMessage = null, $repliedBy = null)
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now(),
            'reply_message' => $replyMessage,
            'replied_by' => $repliedBy ?? auth()->id(),
        ]);
    }

    public function markAsArchived()
    {
        $this->update(['status' => 'archived']);
    }

    public function isUnread()
    {
        return $this->status === 'unread';
    }

    public function isReplied()
    {
        return $this->status === 'replied';
    }

    public function isArchived()
    {
        return $this->status === 'archived';
    }
}
