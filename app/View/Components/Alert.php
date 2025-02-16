<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $messages;

    public function __construct($type, $messages)
    {
        $this->type = $type;
        $this->message = $messages;
    }

    public function render()
    {
        return view('components.alert');
    }
}