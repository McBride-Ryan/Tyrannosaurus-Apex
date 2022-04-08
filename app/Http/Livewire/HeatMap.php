<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class HeatMap extends Component
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
        $heatmap = new \App\Models\HeatMap();
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
        return view('livewire.heat-map', [
            'options' => $this->options,
        ]);
    }
}
