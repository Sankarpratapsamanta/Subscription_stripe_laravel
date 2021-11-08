@extends('admin.layout.app')

@section('content')



<div>
<h2 class="intro-y text-lg font-medium mt-10">
    Edit  Plan
</h2>
</div>
<br>
<div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                    
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/plans/'.$plan->id) }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}

                              
                                

                                <div class="form-group mb-5">
                                    <h6 class="text-muted">Price</h6>
                                    <input type="text" name="price"  class="form-control">
                                </div>

                                <div class="form-group mb-5">
                                    <h6 class="text-muted">Duration</h6>
                                    <select name="duration" id="plan" class="form-control w-full">
                                        <option value="0">Select Duration</option>
                                        <option value="30">Monthly</option>
                                        <option value="365">Yearly</option>
                                        <option value="1">Days</option>

                                    </select>
                                </div>
            
                                <div class="form-group mb-5">
                                    <div>
                                        <button type="submit" class="btn btn-raised btn-primary waves-effect waves-light mb-0">
                                            Submit
                                        </button>
                                        <a href="{{url('admin/coupon')}}" class="btn btn-raised btn-danger waves-effect waves-light mb-0">
                                        Cancel
                                        </a>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div> 



@endsection