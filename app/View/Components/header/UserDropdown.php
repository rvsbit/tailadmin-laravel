<?php

namespace App\View\Components\header;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserDropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public $user;

    public function __construct()
    {
        $this->user = session('user');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // return view('components.header.user-dropdown');

        return view('components.header.user-dropdown', [
            'user' => session('user')
        ]);
    }
}
