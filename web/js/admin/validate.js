const form     = document.getElementById('login');
const username = document.getElementById('username');
const password = document.getElementById('password');

form.addEventListener('submit', (e) => {
    let errors = [];
    [username , password].forEach((el) => {
        if (el.value === '') {
            errors.push({ 'element' : el.id , 'type' : 'danger' , 'message' : `Поле ${el.id} не должно быть пустым` });
        } else {
            if (document.body.contains(document.getElementById(`${el.id}_error`))) {
                document.getElementById(`${el.id}_error`).remove();
            }
        }
    });
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