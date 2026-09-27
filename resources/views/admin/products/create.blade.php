@extends('layouts.admin')

@section('title', 'افزودن غذای جدید')

@section('content')

  <h1 class="admin-heading">افزودن غذای جدید</h1>

  <div class="admin-card">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
      @include('admin.products._form')
    </form>
  </div>

@endsection
