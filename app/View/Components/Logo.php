<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $src = 'images/logo.png',
        public string $alt = 'Logo',
        public string $size = 'lg',
        public bool $animated = true
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.logo');
    }
}
