<?php


namespace App\Admin;


use App\Entity\Training;
use App\Entity\User;
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

class UserAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {


        $formMapper->add('FIO', TextType::class);
        $formMapper->add('email', TextType::class);
        $formMapper->add('phonenumber', TextType::class);
        $formMapper->add('password', TextType::class);
        $formMapper->add('traininggroup', ModelType::class, [
                'class' => Training::class,
                'property' => 'Name',
                'mapped' => true,
                'required' => false,
                'expanded' => true,
                'multiple'    => true,
                'by_reference' => false
            ])
        ;

        $formMapper->add('birthdate');
        $formMapper->add('gender');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
//        $datagridMapper->add('FIO');
//        $datagridMapper->add('email');
//        $datagridMapper->add('password')
        $datagridMapper->add('traininggroup', null, [], EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'Name',
            ]);

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('FIO');
        $listMapper->addIdentifier('email');
        $listMapper->addIdentifier('phonenumber');
        $listMapper->addIdentifier('password');
        $listMapper->add('training.name');
        $listMapper->addIdentifier('birthdate');
        $listMapper->addIdentifier('gender');

    }

//    public function preUpdate($user): void
//    {
//        $this->getModelManager()->updateCanonicalFields($user);
//        $this->getModelManager()->updatePassword($user);
//    }
//    public function preUpdate($user)
//    {
//        $this->getUserManager()->updateCanonicalFields($user);
//        $this->getUserManager()->updatePassword($user);
//    }

//    public function setUserManager(UserManagerInterface $userManager)
//    {
//        $this->userManager = $userManager;
//    }
//


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