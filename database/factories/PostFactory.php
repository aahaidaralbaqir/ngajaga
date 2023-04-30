<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Util\Common as CommonUtil;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Post::class;
    public function definition()
    {
        return [
            'title' => $this->faker->text(50),
            'category' => $this->faker->randomElement(array_keys(CommonUtil::getCategories())),
            'content' => $this->faker->text(),
            'banner' => '1682838076.jpeg',
            'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5])
        ];
    }
}
