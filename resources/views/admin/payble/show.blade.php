@extends('layouts.app')



@section('content')

<div class="col-lg-12 grid-margin stretch-card">

    <div class="card">

        <div class="card-body">

            <h4 class="card-title">Log</h4>

            <div class="table-responsive">

                <table class="table table-striped text-center">

                    <thead>

                        <tr>

                            <th>#</th> {{-- Serial number --}}

                            <th>Pay Amount</th>

                            <th>Due Amount</th>

                        </tr>

                    </thead>

                    <tbody>

                        @php

                            $number = 1; // from controller

                        @endphp

                        @foreach($data as $item)

                        <tr>

                            <td>{{ $number++ }}</td>

                            <td>{{ $item->pay_amount }}</td>

                            <td>{{ $item->due_amount }}</td> 

                        </tr>

                        @endforeach

                    </tbody>

                </table>



                {{-- Pagination links --}}

                <div class="mt-4">

                    {{ $data->links('vendor.pagination.custom-bootstrap') }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

