<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\Boolean;

class Table extends Component
{
    use WithPagination;

    public string $resource;
    public array $columns;
    public string $edit;
    public string $delete;
    public array $eagerLoading;
    public bool $hasImpersonating = false;


    public function render()
    {

        $resource = app("App\Models\\" . $this->resource);
        if (!empty($this->eagerLoading)) {
           $resource = $resource->with($this->eagerLoading);
        }
        return view('livewire.table', [
            'items' => $resource->paginate(10)
        ]);
    }
}
