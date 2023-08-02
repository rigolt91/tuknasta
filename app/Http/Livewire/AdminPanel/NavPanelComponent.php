<?php

namespace App\Http\Livewire\AdminPanel;

use Livewire\Component;

class NavPanelComponent extends Component
{
    public function createCategory()
    {
        $this->emit('openModal', 'admin-panel.category.create-component');
    }

    public function createSubcategory()
    {
        $this->emit('openModal', 'admin-panel.sub-category.create-component');
    }

    public function createProduct()
    {
        $this->emit('openModal', 'admin-panel.product.create-component');
    }

    public function createBranch()
    {
        $this->emit('openModal', 'admin-panel.branch.create-component');
    }

    public function searchOrder()
    {
        $this->emit('openModal', 'admin-panel.order.search-component');
    }

    public function dailySales()
    {
        $this->emit('openModal', 'admin-panel.reports.components.modal-daily-sales');
    }

    public function weeklySales()
    {
        $this->emit('openModal', 'admin-panel.reports.components.modal-weekly-sales');
    }

    public function monthlySales()
    {
        $this->emit('openModal', 'admin-panel.reports.components.modal-month-sales');
    }

    public function yearSales()
    {
        $this->emit('openModal', 'admin-panel.reports.components.modal-year-sales');
    }

    public function render()
    {
        return view('livewire.admin-panel.nav-panel-component');
    }
}
