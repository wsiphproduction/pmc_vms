$('#add-new-vehicle-request').click(function(){
    $('#add-request-modal').modal({
        'show': true
    })
})

$('#add-new-vehicle-request-list').click(function(e){
    $('#add-request-modal').modal({
        'show': true
    })
})

$('#submit-vehicle-request-edit').click(function(){
    $('#vehicle-request-form-edit').submit(function(e){
        e.preventDefault()

        var url = $(this).attr('action')
        var data = $(this).serialize()
        url = url.replace('{id}', $(this).val())

        
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(data){
                window.location.href = '/vehicle/request/list'
            },
            error: function(err){
                console.log(err)
            }
        }).done()
    })
})

$('#submit-vehicle-request').click(function(){
    
    $('#vehicle-request-form').submit(function(e){
        e.preventDefault()

        var url = $(this).attr('action')
        var data = $(this).serialize()

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(data){
                // $('#add-request-modal').modal('hide')
                // $('#vehicle-request-create-toast').toast('show')
                window.location.href = '/vehicle/request/list'
                
            },
            error: function(err){
                let errors = JSON.parse(err.responseJSON.message)
                let validations = errors.validation_errors

                if(validations.date_needed != undefined){
                    $('#date-needed-error').append(validations.date_needed[0])
                }

                if(validations.dept != undefined){
                    $('#dept-error').append(validations.dept[0])
                }

                if(validations.costCode != undefined){
                    $('#costCode-error').append(validations.costCode[0])
                }

                if(validations.purpose != undefined){
                    $('#purpose-error').append(validations.purpose[0])
                }
            }
        }).done()
    });
})

$('#close-toast-vehicle-request').click(function(e){
    $('#vehicle-request-create-toast').removeClass('showing')
})