<?php

namespace App\Domain\Common\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Class UniqueEntityInput
 * @package App\Domain\Common\Validators
 * @Annotation
 */
class UniqueEntityInput extends Constraint
{
    public $message = "Cette valeur doit être unique !";

    public $class;

    public $fields = [];

    public function __construct($options = null)
    {
        if (!is_null($options) && !\is_array($options)) {
            $options = [
                'class' => $options,
            ];
        }
        parent::__construct($options);
        if (!$this->class) {
            throw new MissingOptionsException(
                sprintf("Either option 'class' must be define for constraint %s", __CLASS__),
                ['class']
            );
        }
    }

    public function getRequiredOptions()
    {
        return [
            'fields',
            'class',
        ];
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
