<?php

namespace App\View\Components\Landingpage;

use Closure;
use App\Models\About;
use App\Models\Posts;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class footer extends Component
{
    /**
     * Create a new component instance.
     */
    public $articles;
    public function __construct()
    {
        $this->articles = Posts::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.landingpage.footer');
    }
}
