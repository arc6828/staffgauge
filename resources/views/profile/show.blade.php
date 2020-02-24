@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Profile {{ $profile->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/profile') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/profile/' . $profile->id . '/edit') }}" title="Edit Profile"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('profile' . '/' . $profile->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Profile" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Profile ID</th><td>{{ $profile->id }}</td>
                                    </tr>
                                    <tr><th> Role </th><td> @switch( $profile->role )
                                                @case("admin")
                                                    <div><span class="badge badge-primary">เจ้าหน้าที่</span></div>
                                                    <div>{{ $profile->role }}</div>
                                                @break
                                                         
                                                @case("guest")
                                                    <div><span class="badge badge-warning">สมาชิกทั่วไป</span></div>
                                                    <div>{{ $profile->role }}</div>
                                                @break
                                            @endswitch </td></tr>
                                    <tr><th> User Id </th><td> {{ $profile->user_id }} </td></tr>
                                    <tr><th> Line Id </th><td> {{ $profile->lineid }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
