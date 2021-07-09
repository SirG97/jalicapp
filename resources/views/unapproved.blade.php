@extends('layouts.base')
@section('title', 'Contributions')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="searchbox mt-0 mr-0">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" id="search-contribution" placeholder="Search Contributions" style="border:0;">
                    </div>
                    <div class="search-result">
                        <ul class="list-group list-group-flush" id="search-result-list">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <nav class="nav nav-tabs contribution-nav mr-2">
                    <a class="nav-link"   href="/contributions">Approved</a>
                    <a class="nav-link contribution-active"  href="/unapproved">Unapproved</a>
                </nav>
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Unapproved Transactions
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Customer ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Credit/Debit</th>
                                <th scope="col">Savings type</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Collected by</th>
                                <th scope="col">Posted by</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($contributions) && count($contributions) > 0)
                                @foreach($contributions as $contribution)
                                    <tr>
                                        <td scope="row">{{ $contribution['customer_id'] }}</td>
                                        <td>{{ $contribution['amount'] }}</td>
                                        <td>{{ $contribution['request_type'] }}</td>
                                        <td>{{ $contribution['savings_type'] }}</td>
                                        <td>{{ $contribution['balance'] }}</td>
                                        <td>{{ $contribution['collected_by'] }}</td>
                                        <td>{{ $contribution['posted_by'] }}</td>
                                        <td>{{ $contribution['created_at'] }}</td>
                                            <td>
                                                <button  href="#" class="btn btn-sm btn-primary">
                                                    <span class="fa fa-check"
                                                       title="Approve transaction"
                                                       data-toggle="modal"
                                                       data-target="#approveTransaction"
                                                       data-id="{{ $contribution['contribution_id'] }}"
                                                        >Approve</span>
                                                </button>

                                            </td>

                                    </tr>
                                @endforeach
                                {{-- Delete Modal--}}
                                <div class="modal fade" id="approveTransaction" tabindex="-1" role="dialog" aria-labelledby="approveTransaction" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="approveForm" action="/contribution/approve" method="POST">
                                                    <div class="col-md-12">
                                                        Approve transaction?
                                                        @csrf
                                                        <input type="hidden" id="contribution_id" name="contribution_id" value="">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="approveBtn">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">No Unapproved Transactions</div>
                                    </td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>


@endsection()
