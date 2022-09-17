<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder
{
    /**
     * @param  string  $key
     * @return mixed
     */
    public function data(string $key): mixed
    {
        return config("seeder.{$key}");
    }
}
