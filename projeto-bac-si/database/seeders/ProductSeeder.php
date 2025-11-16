<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Importe o DB
use App\Models\Product; // <-- Importe seu Model

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa a tabela antes de inserir, para evitar duplicatas
        Product::truncate(); 

        Product::create([
            'name' => 'Suco de Laranja',
            'price' => 12.99
        ]);

        Product::create([
            'name' => 'Maçã',
            'price' => 1.50
        ]);

        Product::create([
            'name' => 'Banana (Dúzia)',
            'price' => 8.00
        ]);
    }
}