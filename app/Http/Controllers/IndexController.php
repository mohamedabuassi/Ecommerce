<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductsAttribute;
use PHPUnit\Framework\Constraint\Attribute;

class IndexController extends Controller
{
    //
    public function index(){

      // defaultas db
      // $productall = Product::get();
      // //in descending order
      // $productall = Product::orderBy('id','DESC')->get();
      //in Random order
      $productall = Product::inRandomOrder()->get();
      return view ('index')->with(compact('productall'));
    }


}
