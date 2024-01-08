<?php

namespace App\View\Components;

use Illuminate\View\Component;

class monalisa extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $estatus,$id;

    public function __construct($estatus,$id)
    {
        $this->estatus = $estatus;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.monalisa');
    }
}
