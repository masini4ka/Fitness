<?php


namespace App\Controller;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Swift_Mailer;
use Enqueue\Client\Producer;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class UserAdminController extends CRUDController
{
    public function notifyAction( User $user, \Swift_Mailer $mailer, Container $container)
    {

        $name = $user->getFIO();
        $subject = 'Training notification';
        $email = $user->getEmail();
        $traininggroup=$user->getTraininggroup()->toArray();
        $message = (new \Swift_Message('Training notification'))
            ->setFrom('send@example.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'emails/notificationemail.html.twig',
                    ['name' => $name,
                        'traininggroup' => $traininggroup]
                ),
                'text/html'
            );

        $mailer->send($message);

//        /**
//         * @var \Enqueue\AmqpExt\AmqpContext\AmqpContext $context
//         * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
//         */
//        $this->container = $container;
//        $producer = $container->get('enqueue.producer');
//
//
//        // send event to many consumers
//        $producer->sendEvent('aFooTopic', 'Something has happened');
//
//        // send command to ONE consumer
//        $producer->sendCommand('aProcessorName', 'Something has happened');


        return $this->redirectToRoute('admin_app_user_list');

    }

//    public function index(MessageBusInterface $bus)
//    {
//        $bus->dispatch(new SmsNotification('A string to be sent...'));
//    }
}