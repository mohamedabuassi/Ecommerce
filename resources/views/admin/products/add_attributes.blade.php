@extends('layouts.adminLayout.admin_design')
@section('content')

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home">

                    </i> Home</a> <a href="#">Products</a> <a href="#" class="current">Add Product Attributes</a></div>
            <h1>Products Attributes</h1>
        <!-- @if(Session::has('flash_maessage_error'))
            <div class="alert alert-success alert-danger">
                <strong> {{  Session('flash_maessage_error') }}</strong>

            </div>


        @endif
        @if(Session::has('flash_maessage_success'))
            <div class="alert alert-success alert-success">
                <strong> {{  Session('flash_maessage_success') }}</strong>

            </div>


        @endif -->

        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">

                        <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Add Products Attributes</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form enctype="multipart/form-data" class="form-horizontal"
                                  method="post" action="{{ url('/admin/add-attributes/'.$productDetails->id)}}"
                                  name="add_attribute"
                                  id="add_attribute" novalidate="novalidate">
                                @csrf

                                <div class="control-group">
                                    <label class="control-label">Product Name</label>
                                    <label
                                        class="control-label"><strong>{{$productDetails->product_name}}</strong></label>

                                </div>

                                <div class="control-group">
                                    <label class="control-label">Product code</label>
                                    <label
                                        class="control-label"><strong>{{$productDetails->product_code}}</strong></label>

                                </div>
                                <div class="control-group">
                                    <label class="control-label">Product Color</label>
                                    <label
                                        class="control-label"><strong>{{$productDetails->product_color}}</strong></label>
                                </div>

                                <div class="control-group">

                                    <div class="field_wrapper">
                                        <div style="margin-left: 90px">
                                            <input type="text" name="sku[]" id="sku" placeholder="SKU" style="width: 133px"/>
                                            <input type="text" name="size[]" id="size" placeholder="Size" style="width: 133px"/>
                                            <input type="text" name="price[]" id="price" placeholder="Price" style="width: 133px"/>
                                            <input type="text" name="stock[]" id="stock" placeholder="Stock" style="width: 133px"/>
                                            <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <input type="submit" value="Add Attribute" class="btn btn-success">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
