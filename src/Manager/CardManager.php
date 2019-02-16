<?php
/**
 * Created by PhpStorm.
 * User: alexg78bis
 * Date: 2019-02-13
 * Time: 07:37
 */

namespace App\Manager;


use App\Entity\Card;
use App\Repository\CardRepository;

class CardManager
{

    private $cardRepository;

    /**
     * CardManager constructor.
     */
    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function getCard(int $id) : ?Card
    {
        return $this->cardRepository->find($id);
    }

    public function getAll(): ?array {
        return $this->cardRepository->findAll();
    }
}