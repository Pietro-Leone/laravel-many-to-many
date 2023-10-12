@extends('layouts.app')
@section('content')

<div class="container py-5">
  <div class="row gy-5">

    @foreach ($projects as $element)
    <div class="col d-flex justify-content-center">

      <div class="card-box">
        <div class="card h-100" style="width: 18rem;">
          <img src="{{asset("storage/" . $element->thumb)}}" class="card-img-top object-fit-cover h-100" alt="{{$element->title}}">
          <div class="card-body">
            <h5 class="card-title text-center"><a class="text-decoration-none text-white" href="{{route("admin.projects.show", $element->slug)}}">{{$element->title}}</a></h5>
          </div>
        </div>
      </div>

    </div>
    @endforeach


  </div>
</div>

@endsection