@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col">
      <div class="card mt-5">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h2 class="fs-4 text-lg my-4">
              {{ $project->title }}
            </h2>
              <a class="nav-link d-flex align-items-center" href="{{ Route("admin.projects.edit", $project->slug)}}"><i class="fa-solid fa-pen-to-square me-1"></i>Modifica</a>
          </div>
          <div class="d-flex pt-2">
            <div class="row">
              <div class="col-12 col-md-4 text-center"><img class="w-100 object-fit-cover" src="{{ asset("storage/" . $project->thumb) }}"
                  alt="{{ $project->title }}">
              </div>
              <div class="col-12 col-md-8 mt-5 mt-md-0 d-flex flex-column">
                <p class="text-break">{{$project->description}}</p>
                <div class="mt-auto">
                  <div class="d-flex">
                    <div class="col-3 me-2">Tipo:</div>
                    <div>{{$project->type->name ?? "Non definito"}}</div>
                  </div>
                  <div class="d-flex">
                    <div class="col-3 me-2">Data di rilascio:</div>
                    <div>{{$project->release->format("d/m/Y")}}</div>
                  </div>
                  <div>
                    <div class="d-flex">
                      <div class="col-3 me-2">Linguaggi:</div>
                      <div>{{join(", ",json_decode($project["language"]))}}</div>
                    </div>
                  </div>
                  <div>
                    <div class="d-flex">
                      <div class="col-3 me-2">GitHub:</div>
                      <div><a href="{{$project->link}}">{{$project->link}}</a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection