@extends('layouts.base')
@section('title', 'Mark Contribution')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Mark Contribution
                    </div>
                    <form action="{{url('/contribute')}}" method="POST">
                        <div class="container">
                            <div class="row cool-border trx-bg-head py-3">

                                    <div class="col-md-8 offset-md-2">
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
                                    <div class="form-row">
                                        @csrf
                                        <div class="col-md-6 mb-3">
                                            <label for="customer_id">Customer ID</label>
                                            <input type="text" class="form-control" id="customer_id" name="customer_id" value="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Customer Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="" readonly>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="collected_by">Collected by</label>
                                            <input type="text" class="form-control" id="collected_by" name="collected_by" value="" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="posted_by">Posted by</label>
                                            <input type="text" class="form-control" id="posted_by" name="posted_by" value="{{ Auth::user()->name }}" readonly>
{{--                                            <select class="custom-select" id="posted_by" name="posted_by" required>--}}
{{--                                                @if(!empty($staff) && count($staff) > 0)--}}
{{--                                                    <option value="{{ \App\Classes\Request::old('post', 'posted_by') }}">--}}
{{--                                                        {{ \App\Classes\Request::old('post', 'posted_by') ? : ""}}--}}
{{--                                                    </option>--}}
{{--                                                    @foreach($staff as $s)--}}
{{--                                                        <option value={{$s->user_id}}>{{$s->firstname}} {{$s->lastname}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                @else--}}
{{--                                                    <option value="" disabled selected>Create a staff first</option>--}}
{{--                                                @endif--}}
{{--                                            </select>--}}

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="email">Amount</label>
                                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="request_type">Request type</label><br>
                                            <select class="custom-select" id="request_type" name="request_type" required>
                                                <option value="credit">credit</option>
                                                <option value="debit">debit</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="savings_type">Savings type</label><br>
                                            <select class="custom-select" id="savings_type" name="savings_type" required>
{{--                                                <option value="{{ \App\Classes\Request::old('post', 'savings_type') }}">--}}
{{--                                                    {{ \App\Classes\Request::old('post', 'savings_type') ? : ""}}--}}
{{--                                                </option>--}}
                                                <option value="savings">savings</option>
                                                <option value="loan">loan</option>
                                                <option value="property">property</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-5 mb-3">
                                            <label for="id">Date collected</label>
                                            <input type="date" class="form-control" name="collected_on" value="" id="collected_on">
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <label for="description">Description</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="description" value="" id="description"  class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel-footer py-2 mt-2 mr-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm px-3">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection()
