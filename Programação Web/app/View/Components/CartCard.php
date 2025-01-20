<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartCard extends Component
{
    public $items;
    public $total;

    /**
     * Create a new component instance.
     *
     * @param array $items
     * @param float $total
     */
    public function __construct($items, $total)
    {
        $this->items = $items;
        $this->total = $total;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-card');
    }
}
