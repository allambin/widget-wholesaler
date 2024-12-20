<?php

namespace App\Services;

use App\Models\Pack;

class PackService
{
    protected function findCombinationWithLeastAmountOfPacks(int $widgetsQuantity, array $packs)
    {
        $combinations = [];
        
        $total = 0;
        $packs = array_reverse($packs);
        $previousPack = null;
        
        foreach ($packs as $pack) { // going on DESC
            if ($widgetsQuantity - $pack > 0) {
                if (null !== $previousPack) {
                    $combinations[] = $previousPack;
                    $widgetsQuantity -= $previousPack;
                } else {
                    $combinations[] = $pack;
                    $widgetsQuantity -= $pack;
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

    public function computeQuantity(int $widgetsQuantity): array // @todo rename + comments
    {
        if (null !== ($pack = Pack::where('quantity', $widgetsQuantity)->first())) {
            return [$pack->quantity];
        }

        $packs = Pack::orderBy('quantity', 'asc')->get();

        $toKeep = [];
        $fulfilled = false;
        while ($widgetsQuantity > 0) {
            $currentPacks = [];
            foreach ($packs as $key => $pack) {
                $currentPacks[] = $pack->quantity;
                if (array_sum($currentPacks) >= $widgetsQuantity) {
                    $combinations = $this->findCombinationWithLeastAmountOfPacks($widgetsQuantity, $currentPacks);
                    $toKeep = array_merge($toKeep, $combinations);
                    $fulfilled = true;
                    break;
                }
            }

            // only keep the last pack if requirements not yet fulfilled
            if (!$fulfilled) {
                $toKeep[] = $pack->quantity;
            }
            
            $widgetsQuantity -= array_sum($toKeep);
        }

        return $toKeep;
    }
}
