<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Proyectos9 extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
  
     public $estatus,$id,$estado;

    public function __construct($estatus,$id,$estado)
    {
        $this->estatus = $estatus;
        $this->id = $id;
        $this->estado = $estado;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.proyectos9');
    }
}
