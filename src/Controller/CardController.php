<?php

namespace App\Controller;

use App\Manager\CardManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class CardController extends AbstractFOSRestController
{
    /**
     *  Return a specific card
     * @Rest\Get("/api/cards/{id}")
     * @Rest\View(serializerGroups={"card"})
     * @param CardManager $cardManager
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function getOneById(CardManager $cardManager, int $id): \FOS\RestBundle\View\View
    {
        $card = $cardManager->getCard($id);

        if ($card !== null) {
            if ($card->getUser() === $this->getUser()) {
                return $this->view($card);
            }

            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            return $this->view($card);
        }

        throw $this->createNotFoundException('This card doesn\'t exist');
    }

    /**
     *  Return all the card
     * @Rest\Get("/api/cards/")
     * @Rest\View(serializerGroups={"card"})
     * @IsGranted("ROLE_USER")
     * @param CardManager $cardManager
     * @return \FOS\RestBundle\View\View
     */
    public function getAll(CardManager $cardManager): \FOS\RestBundle\View\View
    {
        if($this->isGranted('ROLE_ADMIN')){
            return $this->view($cardManager->getAll());
        }

        return $this->view($this->getUser()->getCards());
    }


    /**
     *  Delete a specific card
     * @Rest\Delete("/api/cards/{id}")
     * @param CardManager $cardManager
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @return \FOS\RestBundle\View\View
     */
    public function delete(
        CardManager $cardManager,
        int $id,
        EntityManagerInterface $entityManager
    ): \FOS\RestBundle\View\View {
        $card = $cardManager->getCard($id);

        if ($card !== null) {
            if ($card->getUser() === $this->getUser()) {
                $entityManager->remove($card);
                $entityManager->flush();
            }

            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $entityManager->remove($card);
            $entityManager->flush();


        } else {
            throw $this->createNotFoundException('This card doesn\'t exist');
        }
    }

}
