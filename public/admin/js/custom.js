
$(document).on('click','#check-all-permissions',function(e){

    if ($(this).prop('checked')==true){
        $('.group-permission').prop('checked',true);
        $('.check-permission').prop('checked',true);
    }

    else{
        $('.group-permission').prop('checked',false);
        $('.check-permission').prop('checked',false);
    }

})

$(document).on('click','.group-permission',function(e){

    if ($(this).prop('checked')==true){
        $(this).parents('li:eq(0)').find('ul .check-permission').prop('checked',true);
    }

    else{
        $(this).parents('li:eq(0)').find('ul .check-permission').prop('checked',false);
    }

})

$(document).on('click','.check-permission',function (e) {
    var checked = $(this).parents('.outer-li:eq(0)').find('.check-permission:checked').length;
    var total = $(this).parents('.outer-li:eq(0)').find('.check-permission').length;
    if(checked == 0)
    {
        $(this).parents('.outer-li:eq(0)').find('.group-permission').prop('checked',false);
    }

    if(checked != 0 && checked == total)
    {
        $(this).parents('.outer-li:eq(0)').find('.group-permission').prop('checked',true);
    }
    else{
        $(this).parents('.outer-li:eq(0)').find('.group-permission').prop('checked',false);
    }
})

$(document).on('click','#allChk',function(e){

    if ($(this).prop('checked')==true){
        $('.singleChk').prop('checked',true);
    }

    else{
        $('.singleChk').prop('checked',false);
    }

})

function removeByIds(ids,url)
{

    var data = {
        ids : ids,
    }

    const swalWithBootstrapButtons = Swal.mixin({

        confirmButtonClass: 'btn btn-success margin5',

        cancelButtonClass: 'btn btn-danger margin5',

        buttonsStyling: false,

    })

    swalWithBootstrapButtons.fire({

        title: 'Are you sure?',

        text: "You won't be able to revert this!",

        type: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Yes, delete it!',

        cancelButtonText: 'No, cancel!',

        reverseButtons: true

    }).then((result) => {

        if (result.value)

    {

        $.ajax({

            type: 'post',
            url: url,
            data: data,
            dateType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },
            success: function (response) {

                if (response) {

                    swalWithBootstrapButtons.fire(

                        'Deleted!',

                        'Deleted Successfully',

                        'success'

                    )

                    location.reload();

                }

            },

            error: function () {



            }

        });

    }

})

}


//page js
$('#add-more-content').click(function(){
    html  = '<div class="form-group">';
    html += '    <textarea class="textarea" name="content2[]"  placeholder="Place some text here"';
    html += '       style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #DDDDDD; padding: 10px;"></textarea>';
    html += '</div>';
    $('.add-more-content').before(html);
    $('.textarea').summernote();
});
