<?php

namespace App\MyProject\Common\Http\Controllers;

use App\MyProject\Api\Attributes\CustomAction;
use App\MyProject\Api\Http\Controllers\Actions\Action;
use App\MyProject\Api\Traits\UsesDefaultIndexMethodTrait;
use App\MyProject\Api\Traits\UsesDefaultShowMethodTrait;
use App\MyProject\Common\Exceptions\ModelNotFoundException;
use App\MyProject\Common\ModelFinderService;
use App\MyProject\Common\Http\Requests\AcknowledgeAlertRequest;
use App\MyProject\Common\Models\Alert;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class AlertController extends Controller
{

    use UsesDefaultIndexMethodTrait,
        UsesDefaultShowMethodTrait;

    /**
     * @param AcknowledgeAlertRequest $request
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws AuthorizationException
     */
    #[CustomAction(Action::UPDATE)]
    public function acknowledge(AcknowledgeAlertRequest $request): JsonResponse
    {
        $this->auth();

        $alert = ModelFinderService::findOrFail(Alert::class, $request->valid()->id);
        $alert->ack();

        return $this->respondWithModel($alert);
    }

}
