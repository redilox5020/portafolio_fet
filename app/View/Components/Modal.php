<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $title;
    public $sizeClass;
    public $footer;
    /**
     * Create a new component instance.
     */
    public function __construct($id, $title, $size = '', $footer = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->sizeClass = match ($size) {
            'sm' => 'modal-sm',
            'lg' => 'modal-lg',
            'xl' => 'modal-xl',
            default => '',
        };
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
