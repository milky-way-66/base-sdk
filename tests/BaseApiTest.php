<?php

namespace Tests\Unit;

use App\MilkyWay\Base;
use PHPUnit\Framework\TestCase;

class BaseApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_refresh_token_api()
    {
        $client_id = "e7171e1f0ca07534545f3159926a5c53";
        $client_secret = "901f005b4660dd11852bd972df1d03db";
        $refresh_token = "a5382fd7adae2fbb9a134fcfe3bc2c22";

        $base = new Base();
        $base->setAuth($client_id, $client_secret, $refresh_token);
        $accessToken = $base->accessToken();

        $this->assertNotNull($accessToken);
    }


    public function test_create_item_api()
    {
        $client_id = "e7171e1f0ca07534545f3159926a5c53";
        $client_secret = "901f005b4660dd11852bd972df1d03db";
        $refresh_token = "a5382fd7adae2fbb9a134fcfe3bc2c22";

        $base = new Base();
        $base->setAuth($client_id, $client_secret, $refresh_token);
        
       
        $data = [
            "title" => "test-product",
            "price" => 2000,
            "stock" => 23
        ];

        $item = $base->createItem($data);

        $this->assertNotNull($item);
    }


    public function test_delete_item_api()
    {
        $client_id = "e7171e1f0ca07534545f3159926a5c53";
        $client_secret = "901f005b4660dd11852bd972df1d03db";
        $refresh_token = "a5382fd7adae2fbb9a134fcfe3bc2c22";

        $base = new Base();
        $base->setAuth($client_id, $client_secret, $refresh_token);
        
               
        $data = [
            "title" => "test-product",
            "price" => 2000,
            "stock" => 23
        ];

        $item = $base->createItem($data);

        $result = $base->deleteItem($item->item_id);

        $this->assertTrue($result->result);
    }

    public function test_save_item_image_api(){
        $client_id = "e7171e1f0ca07534545f3159926a5c53";
        $client_secret = "901f005b4660dd11852bd972df1d03db";
        $refresh_token = "a5382fd7adae2fbb9a134fcfe3bc2c22";

        $base = new Base();
        $base->setAuth($client_id, $client_secret, $refresh_token);
        
               
        $data = [
            "title" => "test-product",
            "price" => 2000,
            "stock" => 23
        ];

        $item = $base->createItem($data);

        $result = $base->saveItemImage($item->item_id, 10, "https://mimi-panda.com/wp-content/uploads/2023/02/marguerite-729510_640.jpg");
        $this->assertNotNull($result);
    }

    public function test_delete_item_image_api()
    {
        $client_id = "e7171e1f0ca07534545f3159926a5c53";
        $client_secret = "901f005b4660dd11852bd972df1d03db";
        $refresh_token = "a5382fd7adae2fbb9a134fcfe3bc2c22";

        $base = new Base();
        $base->setAuth($client_id, $client_secret, $refresh_token);
        
               
        $data = [
            "title" => "test-product",
            "price" => 2000,
            "stock" => 23
        ];

        $item = $base->createItem($data);

        $result = $base->saveItemImage($item->item_id, 10, "https://mimi-panda.com/wp-content/uploads/2023/02/marguerite-729510_640.jpg");
        $result = $base->delereItemImage($item->item_id, 10);

        $this->assertNotNull($result);
    }

    public function test_orders_api()
    {
        $client_id = "e7171e1f0ca07534545f3159926a5c53";
        $client_secret = "901f005b4660dd11852bd972df1d03db";
        $refresh_token = "a5382fd7adae2fbb9a134fcfe3bc2c22";

        $base = new Base();
        $base->setAuth($client_id, $client_secret, $refresh_token);
        

        $result = $base->orders();
        $this->assertNotNull($result);
    }

    public function test_order_detail_api()
    {
        $client_id = "e7171e1f0ca07534545f3159926a5c53";
        $client_secret = "901f005b4660dd11852bd972df1d03db";
        $refresh_token = "a5382fd7adae2fbb9a134fcfe3bc2c22";

        $base = new Base();
        $base->setAuth($client_id, $client_secret, $refresh_token);
        

        $result = $base->order("212");
        $this->assertNotNull($result);
    }
}