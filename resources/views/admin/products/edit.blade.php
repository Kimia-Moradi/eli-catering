@extends('layouts.admin')

@section('title', 'ویرایش غذا')

@section('content')

  <h1 class="admin-heading">ویرایش «{{ $product->name }}»</h1>

  <div class="admin-card">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
      @method('PUT')
      @include('admin.products._form')
    </form>
  </div>

@endsection
