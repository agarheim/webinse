'use strict';

let modal, mess;
//  // Get the modal
 modal=document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
//
// // When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
//
// // When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

$(document).ready(function() {
  tab();

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


//     $("#add_user_save").click(function() {
//
//          $.ajax({
//             // type: 'POST',
//            //  url: "addpost",
//              data: $('#addpost').serialize(),
//              success: function (response) {
//                  alert("Submitted comment");
//                  $("#commentList").append("Name:" + $("#add_user_firstName").val() + "<br/>email:" + $("#add_user_Email").val());
//              },
//              error: function () {
//                  //$("#commentList").append($("#name").val() + "<br/>" + $("#body").val());
//                  alert("There was an error submitting comment");
//              }
//          });
//     });

    //$("#formaddpost").on('submit', (event) => {
    //   event.preventDefault();


       //  let formData = new FormData(document.forms.add_user);
     //   let data = new FormData(document.querySelector("add_user"));

         // let xhr = new XMLHttpRequest();
         // xhr.open('POST', 'addpost', ['async']);
         // xhr.send(['data','dsfasdfasdf']);
    //        fetch('addpost', {
    //            method: 'post',
     //           body: data ,
     //           headers: {
    //                'Content-Type': 'application/form-data;charset=utf-8'
    //            }
   //         })
   //             .then((response) => {
    //                return response.text();
     //           })
    //           .then((body) => {
    //                document.getElementById('commentList').innerHTML = body;//JSON.stringify(body);
     //          })
     // });
    $("#formaddpost").submit(function(event){
        event.preventDefault(); //prevent default action
        var post_url = 'addpost'; //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data
        }).done(function(response){ //
            $("#commentList").html(response);
        });
    });
 });



function tab() {
  $('#guestbook').DataTable(
        { "scrollY": "220px",
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

// function ajaxSuccess () {
//     console.log(this.responseText);
// }
//
// function AJAXSubmit (oFormElement) {
//     if (!oFormElement.action) { return; }
//     var oReq = new XMLHttpRequest();
//     oReq.onload = ajaxSuccess;
//     if (oFormElement.method.toLowerCase() === "post") {
//         oReq.open("post", oFormElement.action);
//         oReq.send(new FormData(oFormElement));
//     } else {
//         var oField, sFieldType, nFile, sSearch = "";
//         for (var nItem = 0; nItem < oFormElement.elements.length; nItem++) {
//             oField = oFormElement.elements[nItem];
//             if (!oField.hasAttribute("name")) { continue; }
//             sFieldType = oField.nodeName.toUpperCase() === "INPUT" ?
//                 oField.getAttribute("type").toUpperCase() : "TEXT";
//             if (sFieldType === "FILE") {
//                 for (nFile = 0; nFile < oField.files.length;
//                      sSearch += "&" + escape(oField.name) + "=" + escape(oField.files[nFile++].name));
//             } else if ((sFieldType !== "RADIO" && sFieldType !== "CHECKBOX") || oField.checked) {
//                 sSearch += "&" + escape(oField.name) + "=" + escape(oField.value);
//             }
//         }
//         oReq.open("get", oFormElement.action.replace(/(?:\?.*)?$/, sSearch.replace(/^&/, "?")), true);
//         oReq.send(null);
//     }
// }