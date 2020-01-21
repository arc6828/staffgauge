@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Ocr {{ $ocr->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/ocr') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/ocr/' . $ocr->id . '/edit') }}" title="Edit Ocr"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('ocr' . '/' . $ocr->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Ocr" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $ocr->id }}</td>
                                    </tr>
                                    <tr><th> Owner </th><td> {{ $ocr->user->name }} </td></tr>
                                    <tr><th> Title </th><td> {{ $ocr->title }} </td></tr>
                                    <tr><th> Content </th><td> {{ $ocr->content }} </td></tr>
                                    <tr><th> Numbers </th><td> {{ $ocr->numbers }} </td></tr>
                                    <tr><th> LineId </th><td> {{ $ocr->lineid }} </td></tr>
                                    <tr><th> UserId </th><td> {{ $ocr->user->name }} </td></tr>
                                    <tr><th> Photo </th><td><img src="{{ url('storage') }}/{{ $ocr->photo }}" width=100 /></td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
