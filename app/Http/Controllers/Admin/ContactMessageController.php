<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::with('replier')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::unread()->count(),
            'read' => ContactMessage::read()->count(),
            'replied' => ContactMessage::replied()->count(),
            'archived' => ContactMessage::archived()->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'stats'));
    }

    public function show(ContactMessage $message)
    {
        // Tandai sebagai dibaca jika belum
        if ($message->isUnread()) {
            $message->markAsRead();
        }

        return view('admin.contact-messages.show', compact('message'));
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|min:10',
        ]);

        $message->markAsReplied($validated['reply_message'], auth()->id());

        // TODO: Kirim email balasan ke pengirim (opsional)

        return redirect()->route('admin.contact-messages.show', $message)
            ->with('success', 'Balasan telah dikirim.');
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAsArchived(ContactMessage $message)
    {
        $message->markAsArchived();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Pesan telah diarsipkan.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Pesan telah dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:mark_read,mark_archived,delete',
            'selected_ids' => 'required|array', // Ubah dari 'messages' ke 'selected_ids'
            'selected_ids.*' => 'exists:contact_messages,id',
        ]);

        $message = '';

        switch ($validated['action']) {
            case 'mark_read':
                ContactMessage::whereIn('id', $validated['selected_ids'])
                    ->update(['is_read' => true, 'read_at' => now()]);
                $message = 'Pesan berhasil ditandai sebagai dibaca';
                break;

            case 'mark_archived':
                ContactMessage::whereIn('id', $validated['selected_ids'])
                    ->update(['is_archived' => true, 'archived_at' => now()]);
                $message = 'Pesan berhasil diarsipkan';
                break;

            case 'delete':
                ContactMessage::whereIn('id', $validated['selected_ids'])->delete();
                $message = 'Pesan berhasil dihapus';
                break;
        }

        return redirect()->route('admin.contact-messages.index')
            ->with('success', $message);
    }
    public function getStats()
    {
        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::unread()->count(),
            'read' => ContactMessage::read()->count(),
            'replied' => ContactMessage::replied()->count(),
            'archived' => ContactMessage::archived()->count(),
        ];

        return response()->json($stats);
    }
}
