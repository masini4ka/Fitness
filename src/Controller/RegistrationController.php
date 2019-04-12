<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\TokenAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
//use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
//use App\Security\LoginFormAuthenticator;

class RegistrationController extends AbstractController
{
    public function sendConfirmationEmailMessage(User $user)
    {

        $confirmationToken = $user->getConfirmationToken();
        $username = $user->getUsername();

        $subject = 'Account activation';
        $email = $user->getEmail();

//        $renderedTemplate = $this->templating->render('AppBundle:Emails:registration.html.twig', array(
//            'username' => $username,
//            'confirmationToken' => $confirmationToken
//        ));

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom(MAILER_FROM)
            ->setReplyTo(MAILER_FROM)
            ->setTo($email);
//            ->setBody($renderedTemplate, "text/html");

        $this->mailer->send($message);

    }

//    /**
//     * @Route("/register", name="app_register")
//     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            ));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/activate/{token}")
     */
    public function confirmAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:User');

        $user = $repository->findUserByConfirmationToken($token);

        if (!$user)
        {
            throw $this->createNotFoundException('We couldn\'t find an account for that confirmation token');
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_registration_confirmed');
    }
}
