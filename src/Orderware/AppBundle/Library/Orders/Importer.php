<?php

namespace Orderware\AppBundle\Library\Orders;

use Orderware\AppBundle\Entity\OrdImport;
#use Orderware\AppBundle\Entity\OrdHeader;
#use Orderware\AppBundle\Entity\OrdLine;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\EntityManager;

class Importer
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Symfony\Component\Validator\Validator\ValidatorInterface */
    protected $validator;

    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function import(OrdImport $ordImport)
    {
    }

}
