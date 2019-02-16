<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends AbstractFOSRestController
{
    private $em;

    /**
     * UserController constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Return the information user (full information)
     * @Rest\Get("/api/users/myInfos/")
     * @Rest\View(serializerGroups={"userAdmin"})
     * @IsGranted("ROLE_USER")
     */
    public function getMyUserInformations(): \FOS\RestBundle\View\View
    {
        return $this->view($this->getUser());
    }

    /**
     * return all user with limited information
     * @Rest\Get("/api/users")
     * @Rest\View(serializerGroups={"user"})
     * @param UserManager $userManager
     * @return \FOS\RestBundle\View\View
     */
    public function getUsers(UserManager $userManager)
    {
        return $this->view($userManager->getUsers());
    }

    /**
     * Return all the user list with all information
     * @Rest\Get("/api/users/full")
     * @Rest\View(serializerGroups={"userAdmin"})
     * @IsGranted("ROLE_ADMIN")
     * @param UserManager $userManager
     * @return \FOS\RestBundle\View\View
     */
    public function getUsersAdmin(UserManager $userManager)
    {
        return $this->view($userManager->getUsers());
    }

    /**
     * Return a specific user (with minimal information)
     * @Rest\Get("/api/users/{id}")
     * @Rest\View(serializerGroups={"user"})
     */
    public function getUserById(UserManager $userManager, int $id)
    {
        return $this->view($userManager->getUser($id));
    }

    /**
     * Return a specific user (with full information)
     * @Rest\Get("/api/users/{id}/full")
     * @Rest\View(serializerGroups={"userAdmin"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function getUserAdminById(UserManager $userManager, int $id)
    {
        return $this->view($userManager->getUser($id));
    }

    /**
     * Return a specific user (with minimal information)
     * @Rest\Post("/api/users/")
     * @Rest\View(serializerGroups={"userAdmin"})
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function addUser(User $user)
    {

//        if ($user->getSubscription()->getId() === null) {
//            throw new RuntimeException('You need to select a subscription');
//        }

//        $entityManager->persist($user);
//        $entityManager->flush();

        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }

    /**
     * Return a specific user (with full information)
     * @Rest\Delete("/api/users/{id}")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteUser(EntityManagerInterface $entityManager, UserManager $userManager, int $id)
    {
        $user = $userManager->getUser($id);
        if($user !== null){
            $entityManager->remove($user);
            $entityManager->flush();
            return $this->view();
        } else {
            throw $this->createNotFoundException('There are no user with this id');
        }
    }

}