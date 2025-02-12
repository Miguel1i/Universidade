<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditPopup extends Component
{
    public $medicamento;
    /**
     * Create a new component instance.
     */
    public function __construct($medicamento)
    {
        $this->medicamento = $medicamento;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-popup');
    }
}
