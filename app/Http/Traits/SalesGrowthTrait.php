<?php

namespace App\Http\Traits;

trait SalesGrowthTrait
{
    public function overallGrowth()
    {
        $this->overall_growth = 0;
        $this->full_percent = 0;

        foreach ($this->products as $key => $product) {
            $this->overall_growth += ($key > 0) ? ($product->amount - $this->growth[$key-1]['amount']) : $this->growth[$key]['amount'];
            $this->full_percent += ($key > 0) ? (($percent = ((($product->amount - $this->growth[$key-1]['amount'])/$product->amount) * 100)) > 0 ? $percent : 0) : 100;
        }
    }
}
