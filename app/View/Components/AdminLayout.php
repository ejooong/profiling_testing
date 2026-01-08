<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public $title;
    
    public function __construct($title = null)
    {
        $this->title = $title ?? 'Dashboard';
    }
    
    public function render()
    {
        return view('layouts.admin');
    }
}   