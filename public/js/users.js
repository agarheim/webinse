'use strict';

let modal, mess, files;
//  // Get the modal
 modal=document.getElementById("myModal");
let span = document.getElementsByClassName("close")[0];
//
// // When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
//
// // When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

$(document).ready(function() {
  tab();
    $('#changeImg').click(function(){
        $('#image').click();
    });
    $('#image').change(function () {
        let imgPath = this.value;
        let ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        if (ext === "gif" || ext === "png" || ext === "jpg" || ext === "jpeg")
            readURL(this);
        else
            alert("Please select image file (jpg, jpeg, png).")
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
//              $("#remove").val(0);
            };
        }
    }
    $('#removeImg').click(function(){
        $('#preview').attr('src', '/upload/users/no_image_jpg.jpeg');
//      $("#remove").val(1);
    });
$ ('#guestbook'). on ('click', 'tbody tr', function () {
        let table = $ ('#guestbook'). DataTable ();
        let tr = $ ( this) .closest ('tr');
        let row = table.row (tr);
        mess='' ;
    mess+='<p>First Name:'+row.data()[0]+'</p>'+
    '<p>Home page:'+row.data()[1]+'</p>'+
    '<p>email:'+row.data()[2]+'</p>'+
    '<p>Date:'+row.data()[3]+'</p>'+
        '<p>Text:'+row.data()[4]+'</p>';
    document.getElementById("modal-content").innerHTML=mess;
    document.getElementById("myModal").style.display = "block";
    });

    $("#formaddpost").submit(function(event){
        event.preventDefault(); //prevent default action
        let post_url = 'addpost'; //get form action url
        let request_method = "POST"; //get form GET/POST method
        let form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url : post_url,
            type: "post",
            data : form_data
        }).done(function(response){ //
            if(response['errst']===0){
                $("#commentList").html(response['error']);
            }
            else if (response['errst']===1) {
                $("#showForm").html(response['html']);
                $("#showTable").html(response['tables']);
                tab();
            }

        });
    });
 });


function tab() {
  $('#guestbook').DataTable(
        { "scrollY": "350px",
            "pageLength": 5,
            "lengthMenu": [ 5, 25, 50, 75, 100 ],
            "searching": false,
            "order": [[ 3, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 1 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 4 ],
                    "visible": false,
                    "searchable": false
                }
            ],

        },

    );
};

