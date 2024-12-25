<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $userId = User::whereNotIn('id', [1, 2])->inRandomOrder()->first()->id;
            $shopId = Shop::inRandomOrder()->first()->id;

            $exists = Review::where('user_id', $userId)
                ->where('shop_id', $shopId)
                ->exists();
        } while ($exists);
        return [
            'user_id' => $userId,
            'shop_id' => $shopId,
            'rating' => $this->faker->numberBetween(1, 5),
            'text' => $this->faker->text(50),//
        ];
    }
}
