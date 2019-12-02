<?php

namespace App\Domain\Common\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEntityInputValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueEntityInput) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\UniqueEntityInput');
        }

        if (null === $value || '' === $value) {
            return;
        }

        $fields = (array) $constraint->fields;

        foreach ($fields as $name) {
            $fieldValue = $value->{'get' . ucfirst($name)}();

            $object = $this->em->getRepository($constraint->class)
                ->findOneBy(
                    [
                        $name => $fieldValue,
                    ]
                );

            if ($object && 0 === $this->context->getViolations()->count()) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
