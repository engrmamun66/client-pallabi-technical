@extends('backend.layouts.admin')
@section('title', ' All Certificates')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
            </div>
            <div>New Certificate</div>
        </div>
    </div>
</div>

<div class="row" id="app">
    <div class="col-md-12 col-sm-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Create New Certificate</div>

            <div class="card-body">
                <form action="">
                    <certificate-component :batches="{{ $batches }}"></certificate-component>
                </form>
            </div>
        </div>
    </div>
</div>
@stop