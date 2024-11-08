<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;
    
    public function definition(): array
    {
        return [
            'title'=> $this->faker->sentence,
            'author'=>$this->faker->name,
            'price'=>$this->faker->randomFloat(2, 10, 100),
        ];
    }
}
