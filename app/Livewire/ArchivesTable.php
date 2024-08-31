<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Archive;

class ArchivesTable extends Component
{
    use WithPagination;

    public $search = '';

    // public function render()
    // {
    //     $archives = Archive::where('title', 'like', '%' . $this->search . '%')->paginate(10);

    //     return view('livewire.archives-table', ['archives' => $archives]);
    // }
}
