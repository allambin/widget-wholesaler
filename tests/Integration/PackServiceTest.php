<?php

namespace Tests\Integration;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Sequence;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Models\Pack;
use App\Services\PackService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\PackSeeder;

class PackServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_compute_correct_quantity_of_packs(): void
    {
        $this->seed(PackSeeder::class);
        
        $service = app(PackService::class);

        $results = $service->computeQuantity(1);
        $valuesCount = array_count_values($results);
        $this->assertCount(1, $results);
        $this->assertEquals(1, $valuesCount[250]);
        
        $results = $service->computeQuantity(250);
        $valuesCount = array_count_values($results);
        $this->assertCount(1, $results);
        $this->assertEquals(1, $valuesCount[250]);
        
        $results = $service->computeQuantity(251);
        $valuesCount = array_count_values($results);
        $this->assertCount(1, $results);
        $this->assertEquals(1, $valuesCount[500]);
        
        $results = $service->computeQuantity(501);
        $valuesCount = array_count_values($results);
        $this->assertCount(2, $results);
        $this->assertEquals(1, $valuesCount[250]);
        $this->assertEquals(1, $valuesCount[500]);
        
        $results = $service->computeQuantity(1001);
        $valuesCount = array_count_values($results);
        $this->assertCount(2, $results);
        $this->assertEquals(1, $valuesCount[250]);
        $this->assertEquals(1, $valuesCount[1000]);
        
        $results = $service->computeQuantity(12001);
        $valuesCount = array_count_values($results);
        $this->assertCount(4, $results);
        $this->assertEquals(1, $valuesCount[250]);
        $this->assertEquals(1, $valuesCount[2000]);
        $this->assertEquals(2, $valuesCount[5000]);
    }
}
