<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;
    public $search = '';
    public $searchInput = '';
    public $minPrice;
    public $maxPrice;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // public function updating($property)
    // {
    //     if (in_array($property, ['search', 'minPrice', 'maxPrice', 'inStockOnly'])) {
    //         $this->resetPage();
    //     }
    // }
    public function applyFilters()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query()
            ->where('is_active', true)
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice))
            ->orderBy('created_at', 'desc');

        return view('livewire.product-list', [
            'products' => $query->paginate(6),
        ]);
    }
}
