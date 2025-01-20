<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckoutCard extends Component
{
    /**
     * Create a new component instance.
     */

    public $items;
    public float $total;
    public function __construct($items, float $total)
    {
        $this->items = $items;
        $this->total = $total;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkout-card');
    }
}
