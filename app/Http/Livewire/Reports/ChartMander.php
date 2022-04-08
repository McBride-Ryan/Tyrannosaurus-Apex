<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;

class ChartMander extends Component
{
    /**
     * @var string|null
     */
    public ?string $chartyChart = 'Charty Chart Chart';

    public function render()
    {
        return view('livewire.reports.chart-apex');
    }
}
