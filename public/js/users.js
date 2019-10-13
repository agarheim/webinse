'use strict';

let modal, mess;
//  // Get the modal
 modal=document.getElementById("myModal");
// let modalcontent = document.getElementById("modal-content");
//
// // Get the button that opens the modal
//var btn = document.getElementById("myBtn");
//
// // Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
//
// // When the user clicks on the button, open the modal
// btn.onclick = function() {
//     modal.style.display = "block";
// }
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
//fetch('loadall')
//    .then((response) => {
 //       return response.json();
 //   })
 //   .then((body) => {

      // console.log(body);
     ///  });

$(document).ready(function() {
   $('#guestbook').DataTable(
        { "scrollY": "220px",
            "pageLength": 5,
            "lengthMenu": [ 5, 25, 50, 75, 100 ],
            "searching": false,
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
    // {
    //     responsive: {
    //         details: {
    //             renderer: function ( api, rowIdx, columns ) {
    //                 var data = $.map( columns, function ( col, i ) {
    //                     return col.hidden ?
    //                         '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
    //                         '<td>'+col.title+':'+'</td> '+
    //                         '<td>'+col.data+'</td>'+
    //                         '</tr>' :
    //                         '';
    //                 } ).join('');
    //
    //                 return data ?
    //                     $('<table/>').append( data ) :
    //                     false;
    //             }
    //         }
    //     }
      //}

 );

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



});



