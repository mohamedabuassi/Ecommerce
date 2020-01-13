<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use Auth;
use PHPUnit\Framework\Constraint\Attribute;
use Session;
use Image;
use Illuminate\Support\Facades\Input;


class ProductsController extends Controller
{
    //
    public function addProduct(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //   echo "<pre>";print_r($data); die;

            if (empty($data['category_id'])) {
                return redirect()->back()->with('flash_maessage_error', 'no Category');

            }


            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if (!empty($data['description'])) {
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }

            $product->price = $data['price'];
            //Upload image
            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    //Resize Image code
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/Products/large/' . $filename;
                    $small_image_path = 'images/backend_images/Products/small/' . $filename;
                    $medium_image_path = 'images/backend_images/Products/medium/' . $filename;

                    //Resize image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);


                    // store image name in products table
                    $product->image = $filename;

                }

            }

            $product->save();
            return redirect('/admin/view-products')->with('flash_maessage_success', 'Product added successfully');


        }
        // category drop down start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' Selected disabled>Select</option>";
        foreach ($categories as $cat) {
            $categories_dropdown .= "<option  value='" . $cat->id . "' >" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_dropdown .= "<option value='" . $sub_cat->id . "'>&nbsp;--&nbsp;" . $sub_cat->name . "</option>";

            }
        }
        // category drop down end
        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }


    public function viewProducts()
    {
        $products = Product::get();
        $products = json_decode(json_encode($products));
        foreach ($products as $key => $val) {
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        //  echo "<pre>";print_r($products);die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function editProduct(Request $request, $id = null)
    {
        $productDetails = Product::where(['id' => $id])->first();
        if ($request->isMethod('post')) {
            $data = $request->all();

            if (empty($data['description'])) {
                $data['description'] = '';
            }
            // echo "<pre>";print_r($data);die;

            if ($request->hasFile('image')) {
                $image_tmp = Input::file('image');
                if ($image_tmp->isValid()) {
                    //Resize Image code
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/backend_images/Products/large/' . $filename;
                    $small_image_path = 'images/backend_images/Products/small/' . $filename;
                    $medium_image_path = 'images/backend_images/Products/medium/' . $filename;

                    //Resize image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
                }

            } else {
                $filename = $data['current_image'];
            }


            Product::where(['id' => $id])->update(['category_id' => $data['category_id'], 'product_name' => $data['product_name'],
                'product_code' => $data['product_code'], 'product_color' => $data['product_color'],
                'price' => $data['price'], 'description' => $data['description'], 'image' => $filename]);


            return redirect()->back()->with('flash_maessage_success', 'Category updated successfully');
        }

        // category drop down start
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' Selected disabled>Select</option>";
        foreach ($categories as $cat) {

            if ($cat->id == $productDetails->category_id) {
                $selected = "selected";

            } else {
                $selected = "";
            }
            $categories_dropdown .= "<option  value='" . $cat->id . "' " . $selected . ">" . $cat->name . "</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {

                if ($sub_cat->id == $productDetails->category_id) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value='" . $sub_cat->id . "'" . $selected . ">&nbsp;--&nbsp;" . $sub_cat->name . "</option>";
            }
        }
        // category drop down end
        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_dropdown'));
    }


    public function deleteProductImage($id = null)
    {
        Product::where(['id' => $id])->update(['image' => '']);
        return redirect()->back()->with('flash_maessage_success', 'Proudct Image has deleted successfully');
    }

    public function deleteProduct($id = null)
    {
        if (!empty($id)) {
            Product::where(['id' => $id])->delete();
            return redirect()->back()->with('flash_maessage_success', 'Product deleted successfully');

        }

    }

    public function addAttributes(Request $request, $id = null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();

        if ($request->isMethod('post')) {
            $data = $request->all();
            //dd($data);
            // echo "<pre>";print_r($data);die;
            foreach ($data['sku'] as $key => $val) {
                if (!empty($val)) {
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            redirect('admin/add-attributes/' . $id)->with('flash_maessage_success', 'Product attributes added successfully');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }
    public function deleteAttribute($id = null){

        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_maessage_success', 'Attribute deleted successfully');


    }
}
