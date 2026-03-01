<?php

namespace App\View\Components\Content;

use App\Models\HomeSection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Home extends Component
{
    /**
     * Create a new component instance.
     */

    public $carousels;
    public function __construct()
    {
        $this->carousels = HomeSection::where('status', 'published')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.home');
    }
}
