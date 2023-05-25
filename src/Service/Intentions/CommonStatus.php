<?php

namespace Singlephon\Nodelink\Service\Intentions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

abstract class CommonStatus
{

    public function generateStatus(): int
    {
        $dataLength = count($this->getData());
        $successfulLength = count($this->getSuccessful());
        $errorsLength = count($this->getErrors());
        $code = ResponseAlias::HTTP_NOT_FOUND;

        if ($dataLength == $successfulLength) $code = HTTP_COMMON_ALTERED;
        if ($errorsLength == $dataLength) $code = HTTP_COMMON_NOT_ALTERED;
        if ($successfulLength and $errorsLength) $code = HTTP_COMMON_PARTIAL_ALTERED;
        if (!$successfulLength and $errorsLength) $code = HTTP_COMMON_NOT_ALTERED;

        return $code;
    }

    abstract public function getErrors();
    abstract public function getSuccessful();
    abstract public function getData();
}
