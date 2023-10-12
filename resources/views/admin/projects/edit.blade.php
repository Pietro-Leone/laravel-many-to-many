@extends('layouts.app')
@section('content')
<div class="container">
  <h2 class="fs-4 text-lg my-4">
    {{ __('Project') }}
  </h2>
  <div class="card p-4 mb-4 bg-dark shadow rounded-lg">
    <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST" enctype="multipart/form-data">
      @csrf()
      @method("PUT")

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Titolo</label>
        <div class="col-sm-10">
          <input type="text" class="form-control @error('title') is-invalid @enderror"
            value="{{old('title', $project->title)}}" name="title">
          @error('title')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Descrizione</label>
        <div class="col-sm-10">
          <textarea class="form-control @error('description') is-invalid @enderror" style="height: 130px;"
            name="description">{{old('description', $project->description)}}</textarea>
          @error('description')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Tipo</label>
        <div class="col-sm-10">
          <select class="form-select" aria-label="Default select example" name="type_id">
            @foreach ($types as $type)
            <option value="{{$type->id}}" {{$project->type_id === $type->id ? "selected" : ""}}>{{$type->name}}</option>
            @endforeach
          </select>
          @error('type_id')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Thumb (URL)</label>
        <div class="col-sm-10">
          <input type="file" class="form-control" name="thumb" accept="image/*">
          @error('thumb')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Rilascio</label>
        <div class="col-sm-10">
          <input type="date" class="form-control @error('release') is-invalid @enderror"
            value="{{old('release', $project->release->format('Y-m-d'))}}" name="release">
          @error('release')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Linguaggi</label>
        <div class="col-sm-10 d-flex flex-wrap">
          <div class="row flex-wrap justify-content-start">
            @foreach ($technologies as $technology)
            <div class="d-flex" style="width: fit-content">
              <input type="checkbox" name="technologies[]" value="{{$technology->id}}" {{
                $project->technologies?->contains($technology) ? 'checked' : '' }} class="form-check-input me-1">
              <label class="form-check-label">{{$technology->name}}</label>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Link</label>
        <div class="col-sm-10">
          <input type="text" class="form-control @error('link') is-invalid @enderror"
            value="{{old('link', $project->link)}}" name="link">
          @error('link')
          <div class="invalid-feedback">{{$message}}</div>
          @enderror
        </div>
      </div>

      <div class="text-center">
        <a class="btn btn-secondary" href="{{ route('admin.projects.index') }}">Annulla</a>
        <button class="btn btn-primary" type="submit">Salva</button>

      </div>

    </form>
    <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST">
      @csrf()
      @method("DELETE")

      <button type="submit" class="btn btn-danger">Elimina</button>

    </form>
  </div>
</div>
@endsection