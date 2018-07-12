<?php declare(strict_types=1);

namespace App\Controller\Ride;

use App\Event\Participation\ParticipationCreatedEvent;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Controller\AbstractController;
use App\Entity\Participation;
use App\Entity\Ride;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class ParticipationController extends AbstractController
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("ride", class="App:Ride")
     */
    public function rideparticipationAction(Registry $registry, EventDispatcherInterface $eventDispatcher, UserInterface $user = null, Ride $ride, string $status): Response
    {
        $participation = $this->getParticipationRepository()->findParticipationForUserAndRide($this->getUser(), $ride);

        if (!$participation) {
            $participation = new Participation();
            $participation
                ->setRide($ride)
                ->setUser($user);
        }

        $participation
            ->setGoingYes($status === 'yes')
            ->setGoingMaybe($status === 'maybe')
            ->setGoingNo($status === 'no');

        $em = $registry->getManager();
        $em->persist($participation);
        $em->flush();

        $eventDispatcher->dispatch(ParticipationCreatedEvent::NAME, new ParticipationCreatedEvent($participation));

        return $this->redirectToObject($ride);
    }
}
