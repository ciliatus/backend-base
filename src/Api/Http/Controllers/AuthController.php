<?php

namespace App\MyProject\Api\Http\Controllers;

use App\MyProject\Api\Attributes\CustomAction;
use App\MyProject\Api\Http\Controllers\Actions\Action;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    #[CustomAction(Action::SHOW)]
    public function check__show()
    {
        return Auth::user() ? $this->respondWithData(Auth::user()->transform()) : $this->respondUnauthenticated();
    }

}
