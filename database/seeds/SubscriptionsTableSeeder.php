<?php

//use CodeFlix\Models\Subscription;
use CodeFlix\Repositories\OrderRepository;
use CodeFlix\Repositories\PlanRepository;
use CodeFlix\Repositories\SubscriptionRepository;
use Illuminate\Database\Seeder;


class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //$subscriptions = factory(Subscription::class, 20)->make();
       $plans = App(PlanRepository::class)->all();
       $orders = App(OrderRepository::class)->all();
       $repository = app(SubscriptionRepository::class);
       foreach (range(1,20) as $element){
           $repository->create([
               'plan_id' => $plans->random()->id,
               'order_id' => $orders->random()->id
           ]);
       }
      /*
          $subscriptions->each(function ($subscription) use($plans,$orders){
              $subscription->plan_id = $plans->random()->id;
              $subscription->order_id = $orders->random()->id;
              $subscription->expires_at = '2017-08-07';
              $subscription->save();
           });
       */
    }

}
