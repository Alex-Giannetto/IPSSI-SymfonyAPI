<?php
/**
 * Created by PhpStorm.
 * User: alexg78bis
 * Date: 2019-02-08
 * Time: 08:06
 */

namespace App\Manager;


use App\Entity\User;
use App\Repository\UserRepository;

class UserManager
{

    private $userRepository;

    /**
     * UserManager constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Return all the users
     * @return array|null
     */
    public function getUsers(): ?array
    {
        return $this->userRepository->findAll();
    }

    /**
     * Return a specific user
     * @param int $id
     * @return User|null
     */
    public function getUser(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * Return a specific user
     * @param int $id
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }
}