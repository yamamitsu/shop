<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MFormula;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MFormula>
 */
class MFormulaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MFormula::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'formula_id' => MFormula::factory(),
            'version' => 100,
            'title' => $this->faker->title(),
            'memo' => 'memo',
            'valid_flag' => 1,
            'created_on' => '2020-10-20',
            'created_at' => '2020-10-20 01:01:01',
            'updated_at' => '2020-10-22 02:02:02',
        ];
    }
}
