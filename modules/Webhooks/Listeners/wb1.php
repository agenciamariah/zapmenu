<?php

namespace Modules\Webhooks\Listeners;

class WebhookOrder
{
    

    public function executaRequestPOSTPraURLFixa($order_info) {

        $client = new \GuzzleHttp\Client();

        $payload = [
            'form_params' => $order_info,
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://app.clube14pontos.com/uploads/integration_asaas.php', $payload);


    }


    private function notify($order,$webhook){
        $client = new \GuzzleHttp\Client();

        $payload = [
            'form_params' => $order->toArray(),
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $webhook, $payload);


        executaRequestPOSTPraURLFixa($order->toArray());


    }

    public function handleOrderAcceptedByAdmin($event){

       

        $order=$event->order;
        $vendor=$order->restorant;

        //Vendor setup
        $webhook_for_vendor=$vendor->getConfig('webhook_url_by_admin','');

        //Admin setup
        $webhook_for_admin=config('webhook.webhook_by_admin');

        //Notify Admin
        if(strlen($webhook_for_admin)>5){
            $this->notify($order,$webhook_for_admin);
        }
        

        //Notify Owner
        if(strlen($webhook_for_vendor)>5){
            $this->notify($order,$webhook_for_vendor);
        }
        
    }

    public function handleOrderAcceptedByVendor($event){
        
      
        $order=$event->order;
        $vendor=$order->restorant;

        //Vendor setup
        $webhook_for_vendor=$vendor->getConfig('webhook_url_by_vendor','');

        //Admin setup
        $webhook_for_admin=config('webhook.webhook_by_vendor');

        //Notify Admin
        if(strlen($webhook_for_admin)>5){
            $this->notify($order,$webhook_for_admin);
        }
        

        //Notify Owner
        if(strlen($webhook_for_vendor)>5){
            $this->notify($order,$webhook_for_vendor);
        }
    }


    public function subscribe($events)
        {
            $events->listen(
                'App\Events\OrderAcceptedByAdmin',
                [WebhookOrder::class, 'handleOrderAcceptedByAdmin']
            );

            $events->listen(
                'App\Events\OrderAcceptedByVendor',
                [WebhookOrder::class, 'handleOrderAcceptedByVendor']
            );
        }
}

?>
