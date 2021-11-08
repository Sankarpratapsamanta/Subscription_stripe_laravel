@extends('admin.layout.app')

@section('content')


<h2 class="intro-y text-lg   font-medium mt-10">
    Users List
</h2>

<br>
<!-- <div class="w-full sm:w-auto flex  mt-4 sm:mt-0">
    <button class="btn btn-primary shadow-md mr-2"> <a href="/admin/addplan">Add New Plan</a> </button>
</div> -->

<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                
                <th class="whitespace-nowrap">NAME</th>
                <th class="text-center whitespace-nowrap">PLAN ID</th>
                <th class="text-center whitespace-nowrap">HAS SUBSCRIBED</th>
                
                <th class="text-center whitespace-nowrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="intro-x">
                
                <td>{{@$user->name}}</td>
                <td class="text-center">{{@$user->price}}</td>
                <td class="text-center">{{@$user->duration}}</td>
                
                <!--  <td class="w-40">
                    <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                </td>-->
                <td class="table-report__action w-56">
                    <div class="flex justify-center items-center">
                        <!--   <a class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a> -->
                        <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> 
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-gray-600 mt-2">
                            Do you really want to delete these records? 
                            <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <a href="{{ url('admin/coupon',@$coupon->id) }}">
                            <button class="btn btn-danger w-24">Delete</button></button>
                        </a>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection