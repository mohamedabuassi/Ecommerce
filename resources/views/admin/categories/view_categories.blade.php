@extends('layouts.adminLayout.admin_design')
@section('content')


    <div id="content">
        <div id="content-header">


            <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home">

                    </i> Home</a> <a href="#">Catgories</a> <a href="#" class="current">View Category</a></div>
            <h1>Catgories</h1>
            @if(Session::has('flash_maessage_error'))
                <div class="alert alert-success alert-danger">
                    <strong> {{  Session('flash_maessage_error') }}</strong>

                </div>


            @endif
            @if(Session::has('flash_maessage_success'))
                <div class="alert alert-success alert-success">
                    <strong> {{  Session('flash_maessage_success') }}</strong>

                </div>


            @endif
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>

                            <h5>Catgories</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Category Level</th>
                                    <th>Category URL</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr class="gradeX">
                                        <td>{{ $category->id}}</td>
                                        <td>{{ $category->name}}</td>
                                        <td>{{ $category->parent_id}}</td>
                                        <td>{{ $category->url}}</td>
                                        <td class="center"><a href="{{ url('/admin/edit-category/'. $category->id )}}"
                                                              class="btn btn-primary btn-mini">Edit</a>
                                            <a
                                                rel="{{ $category->id}}" rel1="delete-category"
                                                <?php /*href="{{ url('/admin/delete-product/'.$product->id )}}"*/?>
                                                class="btn btn-danger btn-mini deleteRecord1"
                                                href="javascript:">Delete</a></td>

                                    </tr>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
