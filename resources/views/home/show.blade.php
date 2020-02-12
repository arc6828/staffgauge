@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Welcome, {{ $profile->user->name }}</div>
                    <div class="card-body">

                        <a class="d-none" href="{{ url('/profile') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/profile/' . $profile->id . '/edit') }}" title="Edit Profile"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form class="d-none" method="POST" action="{{ url('profile' . '/' . $profile->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Profile" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="text-center">
                            <img src="{{ $profile->photo? url('storage').'/'.$profile->photo : url('images/no-image.png') }}" width=200 />
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>User ID</th>
                                        <td>{{ $profile->user->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Profile ID</th>
                                        <td>{{ $profile->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $profile->user->name }} </td></tr>
                                    <tr><th> Role </th><td> {{ $profile->role }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center">
                            <a class="btn btn-success" href="{{ url('ocr') }}">Go to OCR Project</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
