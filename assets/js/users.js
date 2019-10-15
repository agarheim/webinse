'use strict';

let UserTable;

UserTable = document.querySelectorAll('.js-user-edit');

UserTable.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
alert(button.href);
        fetch(button.href, {

             headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
             .then((response) => {
                 return response.text();
              })
             .then((body) => {
                  document.getElementById('tr').innerHTML = body;
             })
    });
});