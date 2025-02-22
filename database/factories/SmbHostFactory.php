<?php 

namespace Database\Factories;

use App\Models\SmbHost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SmbHostFactory extends Factory
{
    protected $model = SmbHost::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'host' => $this->faker->ipv4,
            'username' => $this->faker->userName,
            'password' => bcrypt('password'), // Default password
            'remote_path' => $this->faker->filePath,
            'port' => $this->faker->numberBetween(1024, 65535),
        ];
    }
}
