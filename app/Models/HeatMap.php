<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * HeatMap Chart
 */
class HeatMap extends Chart
{
    use HasFactory;

    public ?array $chart = [
        'type' => 'heatmap',
        'toolbar' => true,
    ];

    /**
     * Get Lead Data from DB to feed into Heatmap
     *
     * @return array
     */
    public function getLeadData(): array
    {
        return DB::table('leads')
            ->join('brands', 'brands.id', '=', 'leads.brand_id')
            ->select(DB::raw("
                COUNT(IF(leads.created_at between DATE_SUB(now(), INTERVAL 49 DAY) and DATE_SUB(now(), INTERVAL 42 DAY), leads.id, NULL)) AS week_1,
                COUNT(IF(leads.created_at between DATE_SUB(now(), INTERVAL 42 DAY) and DATE_SUB(now(), INTERVAL 35 DAY), leads.id, NULL)) AS week_2,
                COUNT(IF(leads.created_at between DATE_SUB(now(), INTERVAL 35 DAY) and DATE_SUB(now(), INTERVAL 28 DAY), leads.id, NULL)) AS week_3,
                COUNT(IF(leads.created_at between DATE_SUB(now(), INTERVAL 28 DAY) and DATE_SUB(now(), INTERVAL 21 DAY), leads.id, NULL)) AS week_4,
                COUNT(IF(leads.created_at between DATE_SUB(now(), INTERVAL 21 DAY) and DATE_SUB(now(), INTERVAL 14 DAY), leads.id, NULL)) AS week_5,
                brands.name as brand_name
            "))
            ->where('leads.created_at', '>', DB::raw('DATE_SUB(now(), INTERVAL 49 DAY)'))
            ->where('leads.brand_id', '>', 300)
            ->groupBy('leads.brand_id')
            ->orderByRaw('count(leads.id) desc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function setData($data): void
    {
        /*$group = $data['group'];
        $table = $data['table'];
        $xRange = $data['xRange'];
        $yRange = $data['yRange'];
        $xColumn = $data['xColumn'];
        $yColumn = $data['yColumn'];

        $this->data[] = DB::table($table)
            ->select([$xColumn, $yColumn])
            ->whereIn($xColumn, $xRange)
            ->whereIn($yColumn, $yRange)
            ->groupBy($group)
            ->get()
            ->toArray();*/

        $this->data = $this->getLeadData();
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
            'colors' => [sprintf('#%06X', random_int(0, 0xFFFFFF))]
        ];
    }

    public function setPlotOptions(): void
    {
        $this->plotOptions = [
            'heatmap' => [
                'distributed' => false,
            ]
        ];
    }

    public function setSeries(): void
    {
        foreach ($this->data as $datum) {
            $this->series[] = [
                'name' => $datum->brand_name,
                'data' => [
                    ['x' => 'W1', 'y' => $datum->week_1],
                    ['x' => 'W2', 'y' => $datum->week_2],
                    ['x' => 'W3', 'y' => $datum->week_3],
                    ['x' => 'W4', 'y' => $datum->week_4],
                    ['x' => 'W5', 'y' => $datum->week_5],
                ],
            ];
        }
    }

    /**
     * Set Chart Title & Styles
     */
    public function setTitle(): void
    {
        $this->title = [
            'text' => 'Leads per Week by Top 5 Brands',
            'align' => 'center',
            'style' => [
                'fontSize' => '24px',
                'margin' => '10px',
            ],
        ];
    }
}
