 $(document).ready(function() {

         $('#example').DataTable( {

      

         dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

        ],

        initComplete: function () {

            this.api().columns().every( function () {

                var column = this;

                var select = $('<select><option value="">Select One</option></select>')

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



 $('#example1').DataTable( {

      

         dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

        ],

        initComplete: function () {

            this.api().columns().every( function () {

                var column = this;

                var select = $('<select><option value="">Select One</option></select>')

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

$('#example2').DataTable( {

      

         dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

        ],

        initComplete: function () {

            this.api().columns().every( function () {

                var column = this;

                var select = $('<select><option value="">Select One</option></select>')

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





$('#example3').DataTable( {

      

        dom: 'Bfrtip',
        "retrieve": true,
        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

        ],

        initComplete: function () {

            this.api().columns().every( function () {

                var column = this;

                var select = $('<select><option value="">Select One</option></select>')

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



$('#example4').DataTable( {

      

         dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

        ],

        initComplete: function () {

            this.api().columns().every( function () {

                var column = this;

                var select = $('<select><option value="">Select One</option></select>')

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

