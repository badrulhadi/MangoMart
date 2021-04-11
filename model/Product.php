<?php

require_once ROOT_DIR.'/helpers/Http.php';

class Product 
{
    private $url;

    public function __construct() 
    {
        $this->url = 'https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products';
    }


    /**
     * get products by pagination
     */
    public function getAllPaginate($page)
    {
        $data_array =  array(
            "page" => $page
        );

        $result = Http::request('GET', $this->url, $data_array);

        return json_decode($result);
    }

    /**
     * get one product by given product id
     */
    public function getOneByID($productID)
    {
        $result = Http::request('GET', $this->url . "/" . $productID);

        return json_decode($result);
    }
}