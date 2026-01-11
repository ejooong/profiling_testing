<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone' => '08' . $this->faker->numerify('##########'),
            'subject' => $this->faker->randomElement([
                'Informasi Umum',
                'Pendaftaran Kader',
                'Kegiatan Partai',
                'Pengaduan',
                'Kerjasama'
            ]),
            'message' => $this->faker->paragraph,
            'status' => 'unread',
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
        ];
    }
}