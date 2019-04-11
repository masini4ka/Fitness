<?php


namespace App\Admin;


use App\Entity\Training;
use App\Entity\User;
use App\Entity\UserTraining;
use App\Form\Type\GenderType;
use App\Form\Type\NotificationType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;
use Sonata\Form\Type\CollectionType;

class UserAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {


        $formMapper->add('FIO', TextType::class)
                    ->add('email', TextType::class)
                    ->add('phonenumber', TextType::class)
                    ->add('password', TextType::class)
                    ->add('traininggroup', ModelType::class, [
                            'class' => Training::class,
                            'property' => 'Name',
                            'mapped' => true,
                            'required' => false,
                            'expanded' => true,
                            'multiple'    => true,
                            'by_reference' => false
                        ])
                    ->add('birthdate')
                    ->add('gender', GenderType::class, [
                    'placeholder' => 'Choose gender option',
                    ])
                    ->add('notificationtype', NotificationType::class, [
                'placeholder' => 'Choose notification option',
                    ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper->add('traininggroup', null, [], EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'Name',
            ]);

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('FIO')
                    ->addIdentifier('email')
                    ->addIdentifier('phonenumber')
                    ->addIdentifier('password')
                    ->add('training.name')
                    ->addIdentifier('birthdate')
                    ->addIdentifier('gender')
                    ->addIdentifier('notificationtype', NotificationType::class);


    }

    /**
     * @param $user* hashes plain password from the admin panel
     */
    public function prePersistUserEntity(User $user) {
        $plainPassword = $user->getPassword();
        $container = $this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
    }
    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)

    {

        $plainPassword= $user->getPassword();
        if (!$plainPassword) {
            return;
        }
        $container = $this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
    }

}