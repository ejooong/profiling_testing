<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function bisa_membuat_pesan_kontak()
    {
        $message = ContactMessage::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'subject' => 'Test Subject',
            'message' => 'Test message content'
        ]);
        
        $this->assertInstanceOf(ContactMessage::class, $message);
        $this->assertEquals('unread', $message->status);
    }

    /** @test */
    public function bisa_filter_pesan_belum_dibaca()
    {
        // Buat 3 pesan: 2 unread, 1 read
        ContactMessage::factory()->count(2)->create(['status' => 'unread']);
        ContactMessage::factory()->create(['status' => 'read']);
        
        $unreadCount = ContactMessage::unread()->count();
        $this->assertEquals(2, $unreadCount);
    }

    /** @test */
    public function bisa_menandai_sebagai_dibaca()
    {
        $message = ContactMessage::factory()->create(['status' => 'unread']);
        
        $message->markAsRead();
        
        $this->assertEquals('read', $message->fresh()->status);
        $this->assertTrue($message->fresh()->isUnread() === false);
    }
}