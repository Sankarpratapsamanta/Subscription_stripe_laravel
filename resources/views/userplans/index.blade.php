@extends('layouts.userlayout')

@section('content')
<div class="container">
    <div class="grid grid-cols-12 gap-6 mt-5">
        @foreach($plans as $plan)
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-feather="credit-card" class="report-box__icon text-theme-11"></i> 
                        <div class="ml-auto">
                            <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer" title="RS {{$plan->price}} per month">{{$plan->price}}/{{$plan->stripe_plan}}  </div>
                        </div>
                    </div>
                    <div class="mt-6 text-center">Package :- {{$plan->plan_name}}</div>
                    @if(@$user->plan_id == @$plan->id)
                    <div class="text-base text-gray-600 mt-1 text-center">
                        <button class="btn btn-secondary w-24 mr-1 mb-2" disabled >Subscribed</button>
                        <a class="btn btn-danger w-24 mr-1 mb-2" href="/plans/cancel/{{$plan->slug}}">Cancel</a>
                    </div>
                    @else
                    <div class="text-base text-gray-600 mt-1 text-center">
                        <a href="/plans/{{$plan->slug}}" class="btn btn-success w-24 mr-1 mb-2">Choose</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection