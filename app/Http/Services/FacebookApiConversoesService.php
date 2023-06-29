<?php
/**
 * Created by PhpStorm.
 * User: diogoazevedo
 * Date: 23/11/15
 * Time: 22:30
 */

namespace App\Http\Services;


use App\Models\Product;
use App\Models\User;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\ActionSource;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use Illuminate\Support\Facades\Session;


class FacebookApiConversoesService
{


    public function PageView($auth,$event_url): void
    {
        $event_name = 'PageView';

        if ($auth === true) {
            $user = auth()->user();
            $this->check($user, $event_name, $event_url);
        } else {
            $this->dont_check($event_name, $event_url);
        }
    }



    public function ViewContent($auth,$event_url,$product): void
    {
        $event_name = 'ViewContent';
        $product = Product::find($product->id);
        $products = [$product];

        if ($auth === true) {
            $user = auth()->user();
            $this->check($user,$event_name,$event_url,null,$products);
        } else {
            $this->dont_check($event_name,$event_url,null,$products);
        }
    }



    public function VisualizacaoPaginaTopicos($auth,$event_url): void
    {
        $event_name = 'VisualizacaoPaginaTopicos';

        if ($auth === true) {
            $user = auth()->user();
            $this->check($user, $event_name, $event_url);
        } else {
            $this->dont_check($event_name, $event_url);
        }
    }



    public function CarrinhoDeCompra($auth,$event_url): void
    {
        $event_name = 'CarrinhoDeCompra';

        $products = [];
        $cart = Session::get('cart');

        foreach($cart->all() as $k=>$item){
            $product = Product::find($k);
            $products[] = $product;
        }

        if ($auth === true) {
            $user = auth()->user();
            $this->check($user,$event_name,$event_url,null,$products);
        } else {
            $this->dont_check($event_name,$event_url,null,$products);
        }


    }



    public function visualizouPaginaDeCadastro($auth,$event_url): void
    {
        $event_name = 'visualizouPaginaDeCadastro';

        if ($auth === true) {
            $user = auth()->user();
            $this->check($user, $event_name, $event_url);
        } else {
            $this->dont_check($event_name, $event_url);
        }
    }


    public function initiateCheckoutPersonalizado($auth,$order,$event_url): void
    {

        $event_name = 'initiateCheckoutPersonalizado';
        $products = [];

        foreach ($order->items as $item){
            $product = Product::find($item->product_id);
            $products[] = $product;
        }

        if ($auth === true) {
            $user = auth()->user();
        } else {
            $user = User::find($order->user_id);
        }

        $this->check($user,$event_name,$event_url,null,$products);


    }

    public function Purchase($auth,$event_url,$order): void
    {

        $event_name = 'Purchase';

        $products = [];
        foreach ($order->items as $item){
            $product = Product::find($item->product_id);
            $products[] = $product;
        }

        if ($auth === true) {
            $user = auth()->user();
        } else {
            $user = User::find($order->user_id);
        }

        $this->check($user,$event_name,$event_url,null,$products);

    }



    private function check($user,$event_name,$event_url,$event_id = NULL,$products = NULL)
    {

        $access_token = 'EAAmStLAm9Y8BABEBXH3SZBP7aJg7nCzc3rIIi5YtzlPwZAULTbReGF7fhcRAkKwXp66Fe9xTh3sw6fP1ZA7GGIN1HYzxt0qkgZCDslgs5MmuCh8gWXHww0vlzYJC1IZBONsaV4xNFQYSFmu7KgAlOgBtIizM8vm5aZB6b44STNG0XkZB2rdZAmWD9V2Wm3gEO0QZD';
        $pixel_id = '234802807650698';

        $api = Api::init('2694579537507727', null, $access_token);
        $api->setLogger(new CurlLogger());


        $user_data = (new UserData())
            // It is recommended to send Client IP and User Agent for Conversions API Events.

            ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
            ->setClientIpAddress(getUserIP())
            ->setDatesOfBirth(array(data_reverse_traco($user->birthdate)))
            ->setFirstNames(array(primeiroNome($user->name)))
            ->setLastNames(array(ultimoNome($user->name)))
            ->setGenders(array($user->gender))
            ->setEmails(array($user->email))
            ->setPhones(array($user->cel))
            ->setZipCodes(array($user->zipcode))
            ->setCities(array($user->city != null ? $user->city->name : null))
            ->setStates(array($user->state != null ? $user->state->name : null))
            ->setCountryCode('br');
            //->setFbc('fb.1.1554763741205.AbCdEfGhIjKlMnOpQrStUvWxYz1234567890')
            // ->setFbp('fb.1.1558571054389.1098115397');



        if ($products != NULL){

            $ids = [];
            $total = 0;
            foreach ($products as $product){
                $ids[] = $product->id;
                $total = $total + $product->stock->offered_price;
            }

            $custom_data = (new CustomData())
                ->setValue($total)
                ->setCurrency("BRL")
                ->setContentType("product")
                ->setContentIds($ids);

            $event = (new Event())
                ->setEventName($event_name)
                ->setEventTime(time())
                ->setEventId($event_id != NULL?$event_id:'')
                ->setEventSourceUrl($event_url)
                ->setUserData($user_data)
                ->setCustomData($custom_data)
                ->setActionSource(ActionSource::WEBSITE);
        }else{

            $event = (new Event())
                ->setEventName($event_name)
                ->setEventTime(time())
                ->setEventId($event_id != NULL?$event_id:'')
                ->setEventSourceUrl($event_url)
                ->setUserData($user_data)
                ->setActionSource(ActionSource::WEBSITE);

        }


        $events = array();
        $events[] = $event;

        $request = (new EventRequest($pixel_id))
           // ->setTestEventCode('TEST57320')
            ->setEvents($events);
        $response = $request->execute();
        //return $response;

    }


    private function dont_check($event_name,$event_url,$event_id = NULL,$products = NULL)
    {

        $access_token = 'EAAmStLAm9Y8BABEBXH3SZBP7aJg7nCzc3rIIi5YtzlPwZAULTbReGF7fhcRAkKwXp66Fe9xTh3sw6fP1ZA7GGIN1HYzxt0qkgZCDslgs5MmuCh8gWXHww0vlzYJC1IZBONsaV4xNFQYSFmu7KgAlOgBtIizM8vm5aZB6b44STNG0XkZB2rdZAmWD9V2Wm3gEO0QZD';
        $pixel_id = '234802807650698';

        $api = Api::init('2694579537507727', null, $access_token);
        $api->setLogger(new CurlLogger());


        $user_data = (new UserData())
            ->setClientIpAddress(getUserIP())
            ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
            ->setCountryCode('br');

        if ($products != NULL){

            $ids = [];
            $total = 0;
                foreach ($products as $product){
                    array_push($ids,$product->id);
                    $total = $total + $product->stock->offered_price;
                }

            $custom_data = (new CustomData())
                ->setValue($total)
                ->setCurrency("BRL")
                ->setContentType("product")
                ->setContentIds($ids);

            $event = (new Event())
                ->setEventName($event_name)
                ->setEventTime(time())
                ->setEventId($event_id != NULL?$event_id:'')
                ->setEventSourceUrl($event_url)
                ->setUserData($user_data)
                ->setCustomData($custom_data)
                ->setActionSource(ActionSource::WEBSITE);

            } else{

            $event = (new Event())
                ->setEventName($event_name)
                ->setEventTime(time())
                ->setEventId($event_id != NULL?$event_id:'')
                ->setEventSourceUrl($event_url)
                ->setUserData($user_data)
                ->setActionSource(ActionSource::WEBSITE);
        }


        $events = array();
        $events[] = $event;

        $request = (new EventRequest($pixel_id))
          //  ->setTestEventCode('TEST57320')
            ->setEvents($events);
        $response = $request->execute();

        //return $response;

    }






}
