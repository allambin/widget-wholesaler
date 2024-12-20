<?php

namespace App\Services;

use App\Models\Pack;

class PackService
{
    /**
     * Find which packs (and how many) to send back, based on the quantity of widgets we want
     */
    public function calculatePacks(int $widgetsQuantity): array
    {
        if (null !== ($pack = Pack::where('quantity', $widgetsQuantity)->first())) {
            return [$pack];
        }

        $packs = Pack::orderBy('quantity', 'asc')->get();

        $toKeep = [];
        $fulfilled = false;
        while ($widgetsQuantity > 0) {
            $currentPacks = [];
            foreach ($packs as $key => $pack) {
                $currentPacks[] = $pack;
                $sum = collect($currentPacks)->sum('quantity');
                // if all the packs we went through can fulfill the requirements, let's find the most efficient way of doing so
                if ($sum >= $widgetsQuantity) {
                    $combinations = $this->findMostEfficientCombinationOfPacks($widgetsQuantity, $currentPacks);
                    $toKeep = array_merge($toKeep, $combinations);
                    $fulfilled = true;
                    break;
                }
            }

            // only keep the last pack if requirements not yet fulfilled (usually happening when $widgetsQuantity > max(pack.quantity))
            if (!$fulfilled) {
                $toKeep[] = $pack;
            }
            
            $widgetsQuantity -= collect($toKeep)->sum('quantity');
        }

        return $toKeep;
    }

    /**
     * Find the least amount of packs that can fulfill the required $widgetsQuantity
     */
    protected function findMostEfficientCombinationOfPacks(int $widgetsQuantity, array $packs)
    {
        $combinations = [];
        
        $total = 0;
        $packs = collect($packs)->sortByDesc('quantity');
        $previousPack = null;
        
        // looping through each pack (quanttiy DESC), if a pack can fulfill the $widgetsQuantity,
        // we keep it in memory, as a smaller pack could also fit the bill.
        // if the smaller pack cannot fulfill the $widgetsQuantity,
        // we either take the previous one if it exists, otherwise we keep this one and keep looping
        foreach ($packs as $pack) { // sorted DESC
            if ($widgetsQuantity - $pack->quantity > 0) {
                if (null !== $previousPack) {
                    $combinations[] = $previousPack;
                    $widgetsQuantity -= $previousPack->quantity;
                } else {
                    $combinations[] = $pack;
                    $widgetsQuantity -= $pack->quantity;
                }
            } else {
                $previousPack = $pack;
            }
        }
        
        if ($widgetsQuantity > 0) {
            $combinations[] = $pack;
        }

        return $combinations;
    }
}
