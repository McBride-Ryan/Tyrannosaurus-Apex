<?php

namespace App\Http\Livewire;

use App\Models\Radial;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RadialBar extends Component
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
        $pie = new Radial();
        $pie->setData([]);
        $pie->setPlotOptions();
        $pie->setSeries();
        $pie->setTitle();
        $pie->setOptions();

        $this->options = json_encode($pie->options);
    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('livewire.radial-bar', [
            'options' => $this->options,
        ]);
    }
}
