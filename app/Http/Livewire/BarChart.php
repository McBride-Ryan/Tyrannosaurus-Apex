<?php

namespace App\Http\Livewire;

use App\Models\Bar;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BarChart extends Component
{
    /**
     * @var string|null
     */
    public ?string $options = '';

    /**
     * Set Bar Chart Configurations
     */
    public function mount(): void
    {
        $heatmap = new Bar();
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
        return view('livewire.bar-chart', [
            'options' => $this->options,
        ]);
    }
}
