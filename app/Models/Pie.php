<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Pie extends Chart
{
    const PIE_DISPLAY_COUNT = 9;

    use HasFactory;

    public ?array $chart = [
        'type' => 'pie',
        'toolbar' => true,
    ];

    /**
     * @var array|null
     */
    public ?array $labels = [];

    /**
     * Get Lead Data from DB to feed into Heatmap
     *
     * @return Collection
     */
    public function getLeadData(): Collection
    {
        return DB::table('leads')
            ->join('brands', 'brands.id', '=', 'leads.brand_id')
            ->select(DB::raw("
                count(*) as series,
                brands.name as label
            "))
            ->where('leads.created_at', '>', DB::raw('DATE_SUB(now(), INTERVAL 2 DAY)'))
            ->whereStatus('qualified')
            ->groupBy('leads.brand_id')
            ->orderByRaw('count(leads.id) desc')
            ->get();
    }

    public function setData($data): void
    {

        $leads = $this->getLeadData();

        $this->data = $leads
            ->take(self::PIE_DISPLAY_COUNT)
            ->push((object) [
                'series' => $leads
                    ->slice(self::PIE_DISPLAY_COUNT)
                    ->sum('series'),
                'label' => 'Other',
            ])
            ->toArray();
    }

    public function setPlotOptions(): void
    {
        $this->plotOptions = [
            'pie' => [
                'size' => 500,
            ]
        ];
    }

    /**
     * Set Options Configuration for Charts
     */
    public function setOptions(): void
    {
        $this->options = [
            'chart' => $this->chart,
            'title' => $this->title,
            'plotOptions' => $this->plotOptions,
            'series' => $this->series,
            'labels' => $this->labels,
            'colors' => $this->colors,
        ];
    }

    /**
     * @throws Exception
     */
    public function setSeries(): void
    {
        foreach ($this->data as $i => $datum) {
            $this->series[$i] = $datum->series;
            $this->labels[$i] = $datum->label;
            $this->colors[$i] = sprintf('#%06X', random_int(0, 0xFFFFFF));
        }
    }

    public function setTitle(): void
    {
        $this->title = [
            'text' => 'Top 10 Brands by Lead Count',
            'align' => 'center',
            'style' => [
                'fontSize' => '24px',
                'margin' => '10px',
            ],
        ];
    }
}
