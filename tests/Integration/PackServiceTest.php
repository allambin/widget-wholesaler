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

        $results = $service->calculatePacks(1);
        $valuesCount = $this->countValues(collect($results));
        $this->assertCount(1, $results);
        $this->assertEquals(1, $valuesCount[250]);
        
        $results = $service->calculatePacks(250);
        $valuesCount = $this->countValues(collect($results));
        $this->assertCount(1, $results);
        $this->assertEquals(1, $valuesCount[250]);
        
        $results = $service->calculatePacks(251);
        $valuesCount = $this->countValues(collect($results));
        $this->assertCount(1, $results);
        $this->assertEquals(1, $valuesCount[500]);
        
        $results = $service->calculatePacks(501);
        $valuesCount = $this->countValues(collect($results));
        $this->assertCount(2, $results);
        $this->assertEquals(1, $valuesCount[250]);
        $this->assertEquals(1, $valuesCount[500]);
        
        $results = $service->calculatePacks(1001);
        $valuesCount = $this->countValues(collect($results));
        $this->assertCount(2, $results);
        $this->assertEquals(1, $valuesCount[250]);
        $this->assertEquals(1, $valuesCount[1000]);
        
        $results = $service->calculatePacks(12001);
        $valuesCount = $this->countValues(collect($results));
        $this->assertCount(4, $results);
        $this->assertEquals(1, $valuesCount[250]);
        $this->assertEquals(1, $valuesCount[2000]);
        $this->assertEquals(2, $valuesCount[5000]);
    }

    protected function countValues($values)
    {
        return collect($values)->groupBy('quantity')->map(function ($items) {
            return $items->count();
        });
    }
}
