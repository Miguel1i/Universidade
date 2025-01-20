<?php

namespace App\View\Components;

use Illuminate\View\Component;


class ProductCard extends Component
{
    public $medicamento;

    public function __construct($medicamento)
    {
        $this->medicamento = $medicamento;
    }

    public function render()
    {
        return view('components.product-card');
    }
}
