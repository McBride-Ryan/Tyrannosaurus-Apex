<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Chart extends Model
{
    use HasFactory;

    /**
     * @var array|null
     */
    public ?array $chart;

    /**
     * @var array|null
     */
    public ?array $colors;

    /**
     * @var array|null
     */
    public ?array $data;

    /**
     * @var array|null
     */
    public ?array $options;

    /**
     * @var array|null
     */
    public ?array $plotOptions;

    /**
     * @var array|null
     */
    public ?array $series;

    /**
     * @var array|null
     */
    public ?array $title;

    /**
     * @var array|null
     */
    public ?array $xLabels;

    /**
     * @var array|null
     */
    public ?array $yLabels;

    /**
     * Obtain and Set Chart Data
     *
     * @param $data
     */
    abstract public function setData($data): void;

    /**
     * Configure Chart Plot Options
     */
    abstract public function setPlotOptions(): void;

    /**
     * Set Series from Data
     */
    abstract public function setSeries(): void;

    /**
     * Set Chart Title & Styles
     */
    abstract public function setTitle(): void;

    /**
     * @param $data
     */
    public function getOptions($data): void
    {
        $this->setData($data);
        $this->setPlotOptions();
        $this->setSeries();
        $this->setOptions();
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
        ];
    }
}
