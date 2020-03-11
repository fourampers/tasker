const emailRegEx    = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
const form          = document.getElementById('create');
const user          = document.getElementById('user');
const email         = document.getElementById('email');
const content       = document.getElementById('content');

form.addEventListener('submit', (e) => {
    let errors = [];
    [user , email , content].forEach((el) => {
        if (el.value === '') {
            errors.push({ 'element' : el.id , 'type' : 'danger' , 'message' : `Поле ${el.id} не должно быть пустым` });
        } else {
            if (document.body.contains(document.getElementById(`${el.id}_error`))) {
                document.getElementById(`${el.id}_error`).remove();
            }
        }
    });
    if (email.value !== '' && email.value.match(emailRegEx) == null) {
        errors.push({ 'element' : email.id , 'type' : 'danger' , 'message' : `Некорректный email` });
    }
    if (errors.length > 0) {
        e.preventDefault();
        errors.forEach((error) => {
            if (!document.body.contains(document.getElementById(`${error.element}_error`))) {
                errorElement = document.createElement('span');
                errorElement.setAttribute('class', `badge badge-${error.type}`);
                errorElement.setAttribute('id', `${error.element}_error`);
                errorElement.innerHTML = error.message;
                document.getElementById(error.element).after(errorElement);
            }
        });
    }
});