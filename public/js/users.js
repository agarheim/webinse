'use strict';

let UserTable;

UserTable = document.querySelectorAll('.js-user-edit');

UserTable.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        fetch(button.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => {
                return response.text();
            })
            .then((body) => {
                document.getElementById('myModal').innerHTML = body;
                modal.style.display = "block";
            })
    });
});

 // Get the modal
 var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}