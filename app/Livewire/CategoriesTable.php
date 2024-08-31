<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoriesTable extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')->paginate(10);

        return view('livewire.categories-table', ['categories' => $categories]);
    }
}
