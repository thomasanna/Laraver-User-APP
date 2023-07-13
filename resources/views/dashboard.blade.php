@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
  
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
  
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Interests</th>
                            <th>Roles </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)   
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>                            
                            <td>{{$user->interests->implode('interest', ', ')}}</td>
                            <td>{{$user->roles->implode('name', ', ')}}</td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                    {{ $users->links() }}
 
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection