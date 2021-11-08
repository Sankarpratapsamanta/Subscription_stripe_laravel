@component('mail::message')
# Remainder Mail

<img style="height:100px" src="https://rachelcorbett.com.au/wp-content/uploads/2018/10/Should-you-tell-people-to-%E2%80%98subscribe-to-your-podcast.jpg" alt="Image">

 Subscribe or we will remove your account

@component('mail::table')
|Remainder|Mail|
|:--------|:---|
@foreach($users as $user)
|{{$user['name']}}||{{$user['email']}}|
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
