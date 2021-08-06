<?php

namespace Core\Contracts\Http;

interface MiddlewareContract
{
    public function validate(\Core\Http\Request $request, array $data);
}
