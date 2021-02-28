<?php

namespace App\MyProject\Common\Http\Controllers;

use App\MyProject\Api\Attributes\CustomAction;
use App\MyProject\Api\Http\Controllers\Actions\Action;
use App\MyProject\Api\Traits\UsesDefaultDestroyMethodTrait;
use App\MyProject\Api\Traits\UsesDefaultIndexMethodTrait;
use App\MyProject\Api\Traits\UsesDefaultShowMethodTrait;
use App\MyProject\Api\Traits\UsesDefaultStoreMethodTrait;
use App\MyProject\Api\Traits\UsesDefaultUpdateMethodTrait;
use App\MyProject\Common\Models\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{

    use UsesDefaultIndexMethodTrait,
        UsesDefaultShowMethodTrait,
        UsesDefaultStoreMethodTrait,
        UsesDefaultUpdateMethodTrait,
        UsesDefaultDestroyMethodTrait;

    /**
     * @param File $file
     * @param string|null $name Dummy to be able to append file name to url for caching and better readability etc
     * @return BinaryFileResponse
     */
    #[CustomAction(Action::SHOW)]
    public function display(File $file, string $name = null): BinaryFileResponse
    {
        return response()->file($file->fs_path);
    }

}
