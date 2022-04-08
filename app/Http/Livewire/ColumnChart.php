<?php

namespace App\Http\Livewire;

use App\Models\Column;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ColumnChart extends Component
{
    /**
     * @var string|null
     */
    public ?string $options = '';

    /**
     * Set Heatmap Chart Configurations
     */
    public function mount(): void
    {
        $heatmap = new Column();
        $heatmap->setData([]);
        $heatmap->setPlotOptions();
        $heatmap->setSeries();
        $heatmap->setTitle();
        $heatmap->setOptions();

        $this->options = json_encode($heatmap->options);
    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('livewire.column-chart', [
            'options' => $this->options,
        ]);
    }
}
