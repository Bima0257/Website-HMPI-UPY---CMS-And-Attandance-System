<?php

namespace App\View\Components\Content;

use App\Models\Event;
use Closure;
use App\Models\ProkerSections;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Activity extends Component
{
    /**
     * Create a new component instance.
     */
    public $proker, $events;
    public function __construct()
    {
        $this->proker = ProkerSections::where('status', 'published')->first();
        $this->events = Event::with('divisi')->whereIn('status', ['ongoing', 'completed'])
            ->whereIn('category', ['Big Event', 'Normal Event'])
            ->orderByRaw("CASE WHEN category = 'Big Event' THEN 1 ELSE 2 END")
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.activity');
    }
}
