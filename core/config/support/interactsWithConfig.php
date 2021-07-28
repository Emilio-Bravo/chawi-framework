<?php

namespace Core\Config\Support;

trait InteractsWithConfig
{
    /**
     * Get the content the specified config directive
     * 
     * @param string $directive
     * @return object
     */
    public function getConfigDirective(string $directive): object
    {
        return (object) require __DIR__ . "/../{$directive}Config.php";
    }
}
