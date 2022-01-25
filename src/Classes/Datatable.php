<?php

namespace Slingmont\Datatable\Classes;

class Datatable
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function render() {
        return view('datatable::datatable', [
            'config' => $this->config
        ])->render();
    }
}
