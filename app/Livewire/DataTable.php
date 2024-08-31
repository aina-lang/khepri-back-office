<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class DataTable extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // Fetch data with optional search filtering
        $posts = Post::where('title', 'like', '%' . $this->search . '%')->paginate(10);

        return view('livewire.data-table', ['posts' => $posts]);
    }
}
