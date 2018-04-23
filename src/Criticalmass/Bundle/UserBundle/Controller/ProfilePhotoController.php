<?php

namespace Criticalmass\Bundle\UserBundle\Controller;

use Criticalmass\Bundle\AppBundle\Form\Type\UserProfilePhotoType;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfilePhotoController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function uploadAction(Request $request, UserInterface $user): Response
    {
        $form = $this->createForm(UserProfilePhotoType::class, $user);

        if ($request->isMethod(Request::METHOD_POST)) {
            return $this->uploadPostAction($request, $user, $form);
        } else {
            return $this->uploadGetAction($request, $user, $form);
        }
    }

    protected function uploadGetAction(Request $request, UserInterface $user, FormInterface $form): Response
    {
        return $this->render('UserBundle:ProfilePhoto:upload.html.twig', [
            'profilePhotoForm' => $form->createView(),
        ]);
    }

    public function uploadPostAction(Request $request, UserInterface $user, FormInterface $form): Response
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->uploadGetAction($request, $user, $form);
    }
}
