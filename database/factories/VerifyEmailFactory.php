<?php

namespace Database\Factories;

use App\Models\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VerifyEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VerifyEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'user_id' => 1,
          'email_token' => Str::random(20)
        ];
    }
}
