<?php

namespace Database\Factories;

use App\Models\Message;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class MessageFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Message::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        return [
            'sender_id' => $users->random(),

            'receiver_id' => $users->random(),

            'body' => $this->faker->text
        ];
    }
}
