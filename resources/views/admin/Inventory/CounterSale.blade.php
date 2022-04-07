@extends('admin.admin_master')


@section('Admindata')




<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Point of Sale</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="app">
                                        <point-of-sale />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('userbackend/plugins/axios/axios.min.js') }}"></script>
    @endsection
