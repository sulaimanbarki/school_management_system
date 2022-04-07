@extends('admin.admin_master')



@section('Admindata')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header" data-card-widget="collapse">
                <h3 class="card-title">Stock Statistics</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            @php
            // join items table, companies, main_categories, sub_categories
            $items = DB::table('items')
            ->join('companies', 'items.company_id', '=', 'companies.id')
            ->join('main_categories', 'items.main_category_id', '=', 'main_categories.id')
            ->join('sub_categories', 'items.sub_category_id', '=', 'sub_categories.id')
            ->whereRaw('items.campusid = companies.campusid and items.campusid = main_categories.campusid and
            items.campusid = sub_categories.campusid and items.campusid = '.Auth::user()->campusid)
            ->select('items.*', 'companies.company_name', 'main_categories.main_category_name',
            'sub_categories.sub_category_name')
            ->get();

            // dd($items);

            @endphp

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
                                    {{-- item table --}}
                                    <table class="table table-striped mytable">
                                        <thead>
                                            <tr>
                                                <th class="select-filter">Item Code</th>
                                                <th class="select-filter">Item Name</th>
                                                <th class="select-filter">Company Name</th>
                                                <th class="select-filter">Main Category Name</th>
                                                <th class="select-filter">Sub Category Name</th>
                                                <th>Quantity</th>
                                                {{-- <th>Price</th> --}}
                                                {{-- <th>Total Price</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->itemcode }}</td>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->company_name }}</td>
                                                <td>{{ $item->main_category_name }}</td>
                                                <td>{{ $item->sub_category_name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                {{-- <td>{{ $item->price }}</td> --}}
                                                {{-- <td>{{ $item->total_price }}</td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // datatable individual column search
        $(document).ready(function() {
            $(document).ready(function() {
    $('.mytable').DataTable( {
        initComplete: function () {
            this.api().columns(".select-filter").every( function () {
                var column = this;
                var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
        });

    </script>
    @endsection