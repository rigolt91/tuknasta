<?php

namespace App\Http\Traits;

trait ProductStartTrait {
    public $product_start;

    public function setStarts($starts)
    {
        $this->starts = $this->getStarts();

        $this->product->productStart ? $this->update($starts) : $this->create($starts);
    }

    public function create($starts)
    {
        switch ($starts) {
            case 1:
                $this->product->productStart()->create(['one' => 1]);
                break;
            case 2:
                $this->product->productStart()->create(['two' => 1]);
                break;
            case 3:
                $this->product->productStart()->create(['three' => 1]);
                break;
            case 4:
                $this->product->productStart()->create(['four' => 1]);
                break;
            case 5:
                $this->product->productStart()->create(['five' => 1]);
                break;
        }
    }

    public function update($starts)
    {
        switch ($starts) {
            case 1:
                $this->product->productStart()->update(['one' => $this->product->productStart->one + 1]);
                break;
            case 2:
                $this->product->productStart()->update(['two' => $this->product->productStart->two + 1]);
                break;
            case 3:
                $this->product->productStart()->update(['three' => $this->product->productStart->three + 1]);
                break;
            case 4:
                $this->product->productStart()->update(['four' => $this->product->productStart->four + 1]);
                break;
            case 5:
                $this->product->productStart()->update(['five' => $this->product->productStart->five + 1]);
                break;
        }
    }

    public function getStarts()
    {
        if($this->product->productStart)
        {
            $starts = [
                1 => $this->product->productStart->one ?: 0,
                2 => $this->product->productStart->two ?: 0,
                3 => $this->product->productStart->three ?: 0,
                4 => $this->product->productStart->four ?: 0,
                5 => $this->product->productStart->five ?: 0,
            ];

            return array_search(max($starts), $starts);
        }
        return 0;
    }
}
