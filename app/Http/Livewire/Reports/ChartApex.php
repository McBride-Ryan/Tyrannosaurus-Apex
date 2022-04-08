<?php

namespace App\Http\Livewire\Reports;

use App\Models\Bar;
use Livewire\Component;

class ChartApex extends Component
{
    public ?string $chartType = 'bar';

    public array $values = [200, 150, 350, 225, 125];

    public string|null $filterOption = null;

    public function updated($propertyName): void
    {
        $this->filterValues($this->filterOption);
    }

    public function filterValues($option): void
    {
        $this->values = array_slice($this->values, 0, $option);
    }

    public function updateValues(): void
    {
        $this->values = [100, 150, 350, 225, 125];
    }

    /**
     * Set Chart Configurations
     */
    public function setChart(): void
    {
        $chart = new Bar();
        $chart->getOptions([
            'limit' => '10',
            'table' => 'leads',
            'xRange' => '',
            'yRange' => '',
            'xColumn' => '',
            'yColumn' => '',
        ]);
    }

    public function render()
    {
        return view('livewire.reports.chart-apex');
    }
}
