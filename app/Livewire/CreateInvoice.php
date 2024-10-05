<?php

namespace App\Livewire;

use Livewire\Component;

class CreateInvoice extends Component
{

    public $userPrompt = "";
    public $step = 0;
    public $chatHistory = [];

    public function render()
    {
        return view('livewire.create-invoice');
    }

    public function start() {
        $this->step++;
        array_push($this->chatHistory, $this->userPrompt);
        $this->userPrompt = "";
        // dd($this->userPrompt);
    }
}
