<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * Column Chart
 */
class Column extends Chart
{
    use HasFactory;

    public ?array $chart = [
        'type' => 'bar',
        'toolbar' => false,
        'dataLabels' => [
            'position' => 'top',
        ],
    ];

    /**
     * Get Lead Data from DB to feed into Bar Chart
     *
     * @return array
     */
    public function getLeadData(): array
    {
        return DB::table('leads')
            ->join('brands', 'brands.id', '=', 'leads.brand_id')
            ->select(DB::raw("
                count(*) as lead_count,
                brands.name as brand_name
            "))
            ->where('leads.created_at', '>', DB::raw('DATE_SUB(now(), INTERVAL 49 DAY)'))
            ->groupBy('leads.brand_id')
            ->orderByRaw('count(leads.id) desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function setData($data): void
    {
        /*$limit = $data['limit'];
        $table = $data['table'];
        $xRange = $data['xRange'];
        $yRange = $data['yRange'];
        $xColumn = $data['xColumn'];
        $yColumn = $data['yColumn'];

        $this->data[] = DB::table($table)
            ->select([$xColumn, $yColumn])
            ->whereIn($xColumn, $xRange)
            ->whereIn($yColumn, $yRange)
            ->limit($limit)
            ->get()
            ->toArray();

        $this->xLabels = array_keys($this->data);
        $this->yLabels = array_values($this->data);*/

        $this->data = $this->getLeadData();
    }

    public function setPlotOptions(): void
    {
        $this->plotOptions = [
            'bar' => [
                'distributed' => true,
            ],
        ];
    }

    public function setSeries(): void
    {
        $data = [];

        foreach ($this->data as $datum) {
            $data[] = [
                'x' => $datum->brand_name,
                'y' => $datum->lead_count,
            ];
        }

        $this->series[] = ['data' => $data];
    }

    public function setTitle(): void
    {
        $this->title = [
            'text' => 'Lead Count by Top 10 Brands',
            'align' => 'center',
            'style' => [
                'fontSize' => '24px',
                'margin' => '10px',
            ],
        ];
    }
}
