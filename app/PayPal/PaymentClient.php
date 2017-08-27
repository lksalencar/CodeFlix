<?php

namespace CodeFlix\PayPal;
use CodeFlix\Events\PayPalPaymentApproved;
use CodeFlix\Models\Plan;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;


class PaymentClient
{
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * PaymentClient constructor.
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }

    /**
     * Class PaymentClient
     *Finalizar o pagamento
     * @package \CodeFlix\PayPal
     * @param Plan $plan
     * @return mixed
     */
    public function doPayment(Plan $plan)
    {
        //fazer o pagamento com o paypal
        $event = new PayPalPaymentApproved($plan);
        event($event);
        return $event->getOrder();
        //fazer o cadastro da order
    }

    /**
     * @param Plan $plan
     * @return Payment
     */
    public function makePayment(Plan $plan)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $duration = $plan->duration = Plan::DURATION_MONTHLY ? 'Mensal' : 'Anual';
        $item = new Item();
        $item
            ->setName("Plano $duration")
            ->setSku($plan->sku)
            ->setCurrency('BRL')
            ->setQuantity(1)
            ->setPrice($plan->value);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details
            ->setShipping(0)
            ->setTax(0)
            ->setSubtotal($plan->value);

        $amount = new Amount();
        $amount
            ->setCurrency('BRL')
            ->setTotal($plan->value)
            ->setDetails($details);

        $payee = new Payee();
        $payee->setEmail(env('PAYPAL_PAYEE_EMAIL'));

        $transaction = new Transaction();
        $transaction
            ->setAmount($amount)
            ->setDescription("Pagamento do plano de assinatura")
            ->setPayee($payee)
            ->setInvoiceNumber(uniqid());

        $baseUrl = url('/');
        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl("$baseUrl/payment/success")
            ->setCancelUrl("$baseUrl/payment/cancel");

        $payment = new Payment();
        $payment
            ->setExperienceProfileId($plan->webProfile->code)
            ->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        $payment->create($this->apiContext);
        return $payment;

    }
}
