@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Staffgauge</div>
                    <div class="card-body">
                        <a href="{{ url('/staffgauge/create') }}" class="btn btn-success btn-sm" title="Add New Staffgauge">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New 
                        </a>

                        <form method="GET" action="{{ url('/staffgauge') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive" >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Addressgauge</th>
                                        <th>Amphoe</th>
                                        <th>District</th>
                                        <th>Province</th>
                                        <th>Latitudegauge</th>
                                        <th>Longitudegauge</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($staffgauge as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->addressgauge }}</td>
                                        <td>{{ $item->amphoe }}</td>
                                        <td>{{ $item->district }}</td>
                                        <td>{{ $item->province }}</td>
                                        <td>{{ $item->latitudegauge }}</td>
                                        <td>{{ $item->longitudegauge }}</td>
                                        <td>
                                            <a href="{{ url('/staffgauge/' . $item->id) }}" title="View Staffgauge"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/staffgauge/' . $item->id . '/edit') }}" title="Edit Staffgauge"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/staffgauge' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Staffgauge" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $staffgauge->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>

               
                
            </div>
        </div>
    </div>
@endsection