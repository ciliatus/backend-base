<?php

namespace App\MyProject\Common\Models;

interface ModelInterface
{

    public function transform(): array;

    public function self(): string;

    public function fk(): string;

    public static function model(): string;

    public static function package(): string;

    public function getIcon(): string;

}
