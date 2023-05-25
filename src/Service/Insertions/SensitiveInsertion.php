<?php

namespace Singlephon\Nodelink\Service\Insertions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Singlephon\Nodelink\Service\Intentions\Insertion;
use Singlephon\Nodelink\Service\Bindings\ResourceTemplate;

/**
 *  Sensitive Insert extends Insertion abstract class
 *  Insert will break if there appear error while update or create
 *
 *  WARNING: THIS INSERTION WILL BREAK INSERTING AFTER ERROR
 *  USE IN RELATED MODEL INSERTION
 */
class SensitiveInsertion extends Insertion
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
                break;
            }

            ResourceTemplate::setCurrentModel($action);
        }
        return $this;
    }
}
