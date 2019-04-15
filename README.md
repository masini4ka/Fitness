### Fitness App
Contains **Symfony** based web application. 

Allows user to 1)register 2)enable his profile by confirming the email 3)view personal data 4)change password

Allows admin to 1)create/update/delete available trainings 2)create/update/delete users 3)Send email notifications to users about trainings they subscribed to.

_Below is a demonstration of how admin can manipulate user data_.
![](public/img/admin.png)
### Prerequisites
- PHP version >= 7.1.3 
- Symfony >=4
- Composer
- Docker (rabbitmq:3-management)
- DoctrineBundle
- FOSUserBundle
- SonataAdminBundle
- SwiftmailerBundle
- TwigBundle
- EnqueueBundle

### Project Details
- Entities User and Training use Doctrine ORM Mapping to establish many-to-many relashionship. Entities can be found in src\Entities folder. 
User extends FOS\UserBundle\Model\User and adds additional fields required into the sqlite db. Two fields are of custom types -  GenderType and NotificationType. (source: src\Form\Type)
- Each entity has admin panel: UserAdmin, TrainingAdmin stored in src\Admin. Both registered as services in config\services as admin.user and admin.training respectively. 
- UserAdmin has custom UserAdminController, which implements sending notification emails with Swift_Mailer. 
- Registration is handled by Controller\RegistrationController.php. Passwords are encoded by argon2i algorithm, confirmationToken is saved into the db and sent as a link to user (function sendConfirmationEmailMessage) before user can access his profile.
```
    access_control:
         - { path: ^/admin, roles: ROLE_ADMIN }
         - { path: /profile, roles: ROLE_USER }
         - { path: /profile/change-password, roles: ROLE_USER }
         - {path: /profile/edit, roles: ROLE_SUPER_ADMIN}
```
- User authentication is based on unique email, and password and is handled by src\Security\LoginFormAuthenticator.php.
- Login/Logout is handled by Controller\SecurityController.php
- Templates, that extend bundle default templates are stored in src\templates\bundles, src\templates\CRUD.
