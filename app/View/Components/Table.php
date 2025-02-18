<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $headers;
    public $rows;
    public $statuses;
    public $columns;
    public $route;
    public $secondaryRoute;
    public $routeType;
    public $docIcon;

    /**
     * Create a new component instance.
     *
     * @param  array  $headers
     * @param  array  $rows
     * @param  array|null  $statuses
     * @param  string|null $route
     * @return void
     */
    public function __construct($headers, $rows, $columns, $statuses = null, $route = null, $routeType = null, $docIcon = false, $secondaryRoute = null)
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->statuses = $statuses;
        $this->columns = $columns;
        $this->route = $route;
        $this->routeType = $routeType;
        $this->docIcon = $docIcon;
        $this->secondaryRoute = $secondaryRoute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.table');
    }
}
