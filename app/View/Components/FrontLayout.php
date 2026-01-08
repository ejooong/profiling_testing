<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FrontLayout extends Component
{
    public $title;
    public $description;
    
    public function __construct($title = null, $description = null)
    {
        $this->title = $title ?? 'NasDem Bojonegoro';
        $this->description = $description ?? 'Website Resmi Partai NasDem Kabupaten Bojonegoro';
    }
    
    public function render()
    {
        return view('layouts.front');
    }
}