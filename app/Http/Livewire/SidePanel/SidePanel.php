<?php

namespace App\Http\Livewire\SidePanel;

use Livewire\Component;

class SidePanel extends Component
{
    public $open = false;
    public $title = 'Default Panel';
    public $component = '';
    public $hidden = 'hidden';

    protected $listeners = ['openPanel', 'closePanel'];

    public function openPanel(string $title, string $component = ''): void
    {
        $this->hidden = '';
        $this->open = true;
        $this->title = $title;
        $this->component = $component;
    }

    public function closePanel()
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.side-panel.side-panel');
    }
}
