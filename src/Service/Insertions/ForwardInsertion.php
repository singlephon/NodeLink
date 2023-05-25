<?php

namespace Singlephon\Nodelink\Service\Insertions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Singlephon\Nodelink\Service\Intentions\Insertion;
use Singlephon\Nodelink\Service\Bindings\ResourceTemplate;

/**
 *  Forward Insert extends Insertion abstract class
 *  Insert even though there is error in previous updated or created model
 *
 *  Warning: DO NOT USE IF MODELS RELATED
 *  FORWARD INSERTION FOR UNRELATED MODEL INSERTION
 */
class ForwardInsertion extends Insertion
{
    public function updateOrCreate(): static
    {
        foreach ($this->data as $model=>$info) {
            $info = ResourceTemplate::getValues($info);

            /** @var Model $model */
            try {
                $action = $model::updateOrCreate(...$info);
                $this->setSuccessful($model, $action->toArray());
            } catch (Exception $ex) {
                $this->setError($ex->getMessage(), $model, $info);
                continue;
            }

            ResourceTemplate::setCurrentModel($action);
        }
        return $this;
    }
}
