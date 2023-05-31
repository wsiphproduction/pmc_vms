$(document).ready(function () {

    $('#dataTableRequests').DataTable({
       initComplete: function(settings, json){
          $('.edit-btn').click(function(){
             $('#edit-request-modal').modal({
                'show': true
             })
          })
       },
       processing: true,
       language: {
          processing: '<span>Processing'
       },
       responsive: true,
       order: [[ 0, 'desc' ]],
       // serverSide: true,
       searching: false,
       lengthChange: false,
       ajax: '{{ route($route) }}',
       columns: [
          { data: 'id' },
          { data: 'dept' },
          { data: 'date_needed' },
          { data: 'created_at' },
          { data: 'purpose' },
          { data: 'status' },
          { data: 'costcode' },
          { data: 'action', searchable: true, orderable: false },
       ]
    })

 })