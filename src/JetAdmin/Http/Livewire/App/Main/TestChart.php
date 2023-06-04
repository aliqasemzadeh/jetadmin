<?php

namespace AliQasemzadeh\JetAdmin\Http\Livewire\AliQasemzadeh\Main;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class TestChart extends Component
{
    public $firstRun = true;
    public $showDataLabels = false;

    public function render()
    {
        $columnChartModel =
            (new ColumnChartModel())
                ->setTitle('Expenses by Type')
                ->addColumn('Food', 75, '#f6ad55')
                ->addColumn('Test', 75, '#f6fd55')
        ;

        return view('jetadmin::livewire.app.main.test-chart', ['columnChartModel' => $columnChartModel]);
    }
}
