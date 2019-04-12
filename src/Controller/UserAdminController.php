<?php


namespace App\Controller;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Swift_Mailer;

class UserAdminController extends CRUDController
{

    public function notifyAction( User $user, \Swift_Mailer $mailer)
    {

        $username = $user->getUsername();
        $subject = 'Training notification';
        $email = $user->getEmail();
        $traininggroup=$user->getTraininggroup()->toArray();
//    dd($traininggroup);
        $message = (new \Swift_Message('Training notification'))
            ->setFrom('send@example.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/notificationemail.html.twig',
                    ['name' => $username,
                        'traininggroup' => $traininggroup]
                ),
                'text/html'
            );

        $mailer->send($message);
        return $this->redirectToRoute('admin_app_user_list');

    }
}