<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavMenu extends Component
{


    public $menuItems;
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menuItems = config('nav-menu');
        $this->user = auth()->user();
        // dd($this->menuItems);
        // dd($this->menuItems[0]['title']);
        // dd($this->menuItems[0]['route']);
        // dd($this->menuItems[0]['icon']);
        // dd($this->menuItems[0]['ability']);
        // dd($this->menuItems[0]['ability'][0]);
        // dd($this->menuItems[0]['ability'][1]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-menu');
    }
}
