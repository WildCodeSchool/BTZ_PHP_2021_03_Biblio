<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use App\Entity\Newsletters\Newsletters;
use App\Entity\Newsletters\Users;
use App\Form\NewslettersType;
use App\Form\NewslettersUsersType;
use App\Repository\Newsletters\NewslettersRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newsletters", name="newsletters_")
 */
class NewslettersController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $user = new Users();
        $form = $this->createForm(NewslettersUsersType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = hash('sha256', uniqid());
            $user->setValidationToken($token);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            $email = (new TemplatedEmail())
                ->from('audap@audap.fr')
                ->to($user->getEmail())
                ->subject('Inscription a la newsletter')
                ->htmlTemplate('emails/inscription.html.twig')
                ->context(compact('user', 'token'));

            $mailer->send($email);

            $this->addFlash('message', 'Inscription en cours de validation');
            return $this->redirectToRoute('app_acceuil');
        }

        return $this->render('newsletters/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmation/{id}/{token}", name="confirmation")
     */
    public function confirm(Users $user, $token): Response
    {
        if ($user->getValidationToken() != $token) {
            throw $this->createNotFoundException('Erreur lors de la validation');
        }
        $user->setIsValid(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);

        $em->flush();

        $this->addFlash('message', 'Validation confirmée, compte activé');

        return $this->redirectToRoute('app_acceuil');
    }

    /**
     * @Route("/prepare", name="prepare")
     */
    public function prepare(Request $request): Response
    {
        $newsletter = new Newsletters();
        $form = $this->createForm(NewslettersType::class, $newsletter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            return $this->redirectToRoute('newsletters_liste');
        }



        return $this->render('newsletters/prepare.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function list(NewslettersRepository $newsletterList)
    {
        return $this->render('newsletters/liste.html.twig', [
            'newslettertsList' => $newsletterList->findAll()
        ]);
    }

    /**
     * @Route("/envoi/{id}", name="envoi")
     */
    public function send(Newsletters $newsletters, MailerInterface $mailer)
    {
        $users = $newsletters->getCategories()->getUsers();

        // TODO: Utiliser l'asynchrone et le composant Messenger
        foreach ($users as $user) {
            if ($user->getIsValid()) {
                $email = (new TemplatedEmail())
                    ->from('audap-newsletter@audap.fr')
                    ->to($user->getEmail())
                    ->subject($newsletters->getName())
                    ->htmlTemplate('emails/newsletters.html.twig')
                    ->context(compact('newsletters', 'user'));
                $mailer->send($email);
            }
        }

        $newsletters->setIsSent(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($newsletters);

        $em->flush();

        return $this->redirectToRoute('newsletters_liste');
    }

    /**
     * @Route("/unsubscribe/{id}/{newsletter}/{token}", name="cancel")
     */
    public function unsubscribe(users $user, Newsletters $newsletter, $token)
    {
        if ($user->getValidationToken() != $token) {
            throw $this->createNotFoundException('page non trouvée');
        }

        $em = $this->getDoctrine()->getManager();

        if (count($user->getCategories()) > 1) {
            $user->removeCategory($newsletter->getCategories());
            $em->persist($user);
        } else {
            $em->remove($user);
        }
        $em->flush();

        $this->addFlash('message', 'Votre désinscription a bien été prise en compte');

        return $this->redirectToRoute('app_acceuil');
    }
}