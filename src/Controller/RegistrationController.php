<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    private $em; 

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator, Slugify $slugify): Response
    {
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
                
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $fullname = $user->getFirstname().' '.$user->getLastname();
            $user->setSlug($slugify->generate($fullname));      
            $user->setRoles(["ROLE_PUBLIC"]);
            // $user->setNewsletter(false);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('notice', 'Inscription validée');

            $guardHandler->authenticateUserAndHandleSuccess($user, $request, $authenticator,'main');

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
