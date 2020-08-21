<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\Product;
use App\Category;
use Exception;

class ReadJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ReadJson';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reads Json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = $this->ask('1 - Categories, 2 - Products');

        $array_cat = '[
            {"external_id": 1, "name": "Category 1"},
            {"external_id": 2, "name": "Category 2"},
            {"external_id": 3, "name": "Category 33333333"}
        ]';

        $array_prod = '[
            {"external_id": 1, "name": "Product 1", "price": 101.01, "category_id": [1,2], "quantity": 15},
            {"external_id": 2, "name": "Product 2", "price": 199.01, "category_id": [2,3], "quantity": 12},
            {"external_id": 3, "name": "Product 3", "price": 999.01, "category_id": [3,1], "quantity": 10}
        ]';

        $json_cat = json_decode($array_cat, true);
        $json_prod = json_decode($array_prod, true);

        if ($result != "1" && $result != "2") {
            $this->error("Write 1 or 2");
        } elseif ($result == 1) {
            self::CategoryJson($json_cat);
        } elseif ($result == 2) {
            self::ProductsJson($json_prod);
        }

        /*$validatedData = $json->validate([
            'description' => 'required|max:1000',
            'name' => 'required|max:200',
        ]);*/

        // $categories = Category::find($json['external_id']);                



        // Category::insert($json);

        // Product::insert($json);

        // $product = new Product();       

        return;
    }

    public static function CategoryJson($json)
    {

        $category_update = new Category;

        foreach ($json as $json_element) {
            $result = Category::where('external_id', $json_element['external_id'])->get();
            if ($result->isEmpty()) {
                Category::insert($json_element);
            } else {
                $category_update->name = $json_element['name'];
                $category_update->external_id = $json_element['external_id'];
                $category_update->update();
            }
        }


        return true;
    }
    public static function ProductsJson($json)
    {

        $product_update = new Product;
        $product_insert = array();

        foreach ($json as $key => $value) {
            $result = Product::where('external_id', $value['external_id'])->get();
            if ($result->isEmpty()) {
                $category_id = array();
                foreach ($value['category_id'] as $item) {
                    array_push($category_id, $item);
                }
                for ($i = 0; $i < count($category_id); $i++) {
                    $product_insert["external_id"] = $value["external_id"];
                    $product_insert["name"] = $value["name"];
                    $product_insert["price"] = $value["price"];
                    $product_insert["category_id"] = $category_id[$i];
                    $product_insert["quantity"] = $value["quantity"];
                    Product::insert($product_insert);
                }
            } else {
                $category_id = array();
                foreach ($value['category_id'] as $item) {
                    array_push($category_id, $item);
                }
                for ($i = 0; $i < count($category_id); $i++) {
                    $product_update->external_id = $value["external_id"];
                    $product_update->name = $value["name"];
                    $product_update->price = $value["price"];
                    $product_update->category_id = $category_id[$i];
                    $product_update->quantity = $value["quantity"];
                    $product_update->update();
                }
            }
        }
        return true;
    }
}
