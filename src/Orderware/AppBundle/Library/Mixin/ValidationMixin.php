<?php

namespace Orderware\AppBundle\Library\Mixin;

use \InvalidArgumentException;

trait ValidationMixin
{

    private function validate($entity, $entityName, $uniqueKeyValue)
    {
        $errors = $this->getValidator()
            ->validate($entity);

        if ($errors->count() > 0) {
            throw new InvalidArgumentException(
                sprintf("Invalid %s(%s).%s: %s", $entityName, $uniqueKeyValue, $errors[0]->getPropertyPath(), $errors[0]->getMessage())
            );
        }

        return true;
    }

}
