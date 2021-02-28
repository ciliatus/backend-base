<?php

namespace App\MyProject\Common\Http\Controllers;


use App\MyProject\Api\Http\Controllers\ControllerInterface;

abstract class Controller extends \App\MyProject\Api\Http\Controllers\Controller implements ControllerInterface
{

    /**
     * @var string
     */
    protected string $package = 'Common';
}
