<?php

namespace App\Manager;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;

class SubscriptionManager
{
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Return an array containing all the subscription
     * @return array|null
     */
    public function getSubscriptions(): ?array
    {
        return $this->subscriptionRepository->findAll();
    }

    /**
     * Return the subscription
     * @return array|null
     */
    public function getSubscription($id): ?Subscription
    {
        return $this->subscriptionRepository->find($id);
    }

}