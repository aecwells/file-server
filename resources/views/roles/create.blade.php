{{-- filepath: /home/cwells/projects/file-server/resources/views/roles/create.blade.php --}}
@extends('layouts.app')

@php
// use Illuminate\Support\Facades\Form;
@endphp

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center py-4">
        <h2 class="text-2xl font-semibold">Create New Role</h2>
        <a class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded" href="{{ route('roles.index') }}"> Back</a>
    </div>

    @if (count($errors) > 0)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
    <form action="{{ route('roles.store') }}" method="POST">
    @csrf
    </div>
    @endif
            <x-input name="name" placeholder="Name" class="form-control border rounded w-full py-2 px-3" />
            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control border rounded w-full py-2 px-3']) !!}
    <div class="grid grid-cols-1 gap-6">
        <div class="form-group">
            <x-input name="name" placeholder="Name" class="form-control border rounded w-full py-2 px-3" />
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control border rounded w-full py-2 px-3')) !!}
            <label><input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name">
            <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
            <strong>Permission:</strong>
            <br/>
            <label><input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name">
            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
        </div>
    </form>
    {!! Form::close() !!}
</div>
@endsection