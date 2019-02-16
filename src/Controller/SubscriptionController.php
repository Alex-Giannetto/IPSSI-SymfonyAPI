<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Manager\SubscriptionManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SubscriptionController extends AbstractFOSRestController
{

    private $subscriptionManager;

    /**
     * SubscriptionController constructor.
     */
    public function __construct(SubscriptionManager $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * Return all the subscription
     * @Rest\Get("/api/subscriptions")
     * @Rest\View(serializerGroups={"Subscription"})
     */
    public function subscriptionsList()
    {
        $subscriptions = $this->subscriptionManager->getSubscriptions();
        return $this->view($subscriptions);
    }

    /**
     * Return the subcription
     * @Rest\Get("/api/subscriptions/{id}")
     * @Rest\View(serializerGroups={"Subscription"})
     * @param int $id
     * @return \FOS\RestBundle\View\View|HttpException
     */
    public function subscription(int $id)
    {
        $subscription = $this->subscriptionManager->getSubscription($id);
        return $this->view($subscription);
    }

    /**
     * Add a new subscription
     * @Rest\Post("/api/subscriptions")
     * @ParamConverter("subscription", converter="fos_rest.request_body")
     * @param Subscription $subscription
     * @param EntityManagerInterface $entityManager
     * @return \FOS\RestBundle\View\View
     */
    public function addSubscription(Subscription $subscription, EntityManagerInterface $entityManager)
    {
        $entityManager->persist($subscription);
        $entityManager->flush();
        return $this->view($subscription);
    }

    /**
     * Delete a subscription
     * @View(statusCode=204)
     * @Rest\Delete("/api/subscriptions/{id}")
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param SubscriptionManager $subscriptionManager
     */
    public function deleteSubscription(
        int $id,
        EntityManagerInterface $entityManager,
        SubscriptionManager $subscriptionManager
    ) {
        $subscription = $subscriptionManager->getSubscription($id);
        if ($subscription !== null) {
            if(count($subscription->getUsers()) === 0){
                $entityManager->remove($subscription);
                $entityManager->flush();
            } else {
                throw new \RuntimeException('Cannot delete a subscription which has one or plus user!');
            }
        } else {
            throw $this->createNotFoundException('Cannot delete an inexisting subscription');
        }
    }

    /**
     * Modify an existing subscription
     * @Rest\Patch("/api/subscriptions/{id}")
     * @ParamConverter("subscription", converter="fos_rest.request_body")
     * @param int $id
     * @param Subscription $subscription
     * @param EntityManagerInterface $entityManager
     * @param SubscriptionManager $subscriptionManager
     * @return \FOS\RestBundle\View\View
     */
    public function modifySubscription(
        int $id,
        Subscription $subscription,
        EntityManagerInterface $entityManager,
        SubscriptionManager $subscriptionManager
    ) {

        $currentSubscription = $subscriptionManager->getSubscription($id);
        if ($currentSubscription !== null) {
            $currentSubscription->setName($subscription->getName());
            $currentSubscription->setSlogan($subscription->getSlogan());
            $currentSubscription->setUrl($subscription->getUrl());

            $entityManager->persist($currentSubscription);
            $entityManager->flush();

            return $this->view($currentSubscription);
        }

        throw $this->createNotFoundException('Cannot modify an inexisting subscription');
    }
}
