<?php

namespace CodeFlix\Events;


use CodeFlix\Models\Plan;

class PayPalPaymentApproved
{
    /**
     * @var Plan
     */
    private $plan;
    private $order;
    /**
     * Create a new event instance.
     *
     * @param Plan $plan
     */
    public function __construct(Plan $plan)
    {
        //
        $this->plan = $plan;
    }
    /**
     * @return Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

}
