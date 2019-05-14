<?php declare(strict_types=1);

namespace App\Criticalmass\ViewStorage;

use App\EntityInterface\ViewableInterface;
use JMS\Serializer\SerializerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpAmqpLib\Exception\AMQPIOException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RobustViewStorageCache extends ViewStorageCache
{
    /** @var ViewStoragePersisterInterface $viewStoragePersister */
    protected $viewStoragePersister;

    /** @var RegistryInterface $registry */
    protected $registry;

    public function __construct(RegistryInterface $registry, ViewStoragePersisterInterface $viewStoragePersister, TokenStorageInterface $tokenStorage, ProducerInterface $producer, SerializerInterface $serializer)
    {
        $this->viewStoragePersister = $viewStoragePersister;
        $this->registry = $registry;

        parent::__construct($tokenStorage, $producer, $serializer);
    }

    public function countView(ViewableInterface $viewable): void
    {
        try {
            parent::countView($viewable);
        } catch (AMQPIOException $exception) {
            // rabbit is not available, so just throw everything into the database and do not care about performance

            $view = $this->createView($viewable);

            $this->viewStoragePersister->storeView($view);

            $this->registry->getManager()->flush();
        }
    }
}
