<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Radial extends Chart
{
    use HasFactory;

    public ?array $chart = [
        'type' => 'radialBar',
        'toolbar' => true,
        'height' => 500,
    ];

    /**
     * @var array|null
     */
    public ?array $labels = [];

    /**
     * Get Lead Data from DB to feed into Heatmap
     *
     * @return array
     */
    public function getLeadData(): array
    {
        return DB::table('contracts')
            ->join('companies', 'companies.id', '=', 'contracts.company_id')
            ->select(DB::raw("
                round(((sum(qualified_leads) / sum(contracts.quota)) * 100), 0) as series,
                companies.name as label
            "))
            ->havingRaw('series < 100')
            ->havingRaw('series > 0')
            ->groupBy('companies.id')
            ->limit(3)
            ->get()
            ->toArray();
    }

    public function setData($data): void
    {
        $this->data = $this->getLeadData();
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
            'text' => 'Progress Towards Lead Quota',
            'align' => 'center',
            'style' => [
                'fontSize' => '24px',
                'margin' => '10px',
            ],
        ];
    }
}
