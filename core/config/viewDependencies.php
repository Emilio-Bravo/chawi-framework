<?php

return [
    '_session' => new \Core\Http\Persistent,
    '_flash' => new \Core\Support\Flash,
    '_view' => new \Core\Client\ViewHelper
];
