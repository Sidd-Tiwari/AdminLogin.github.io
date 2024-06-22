function validateForm() {
    const name = document.getElementById('fullname').value;
    const phone = document.getElementById('mobile').value;

    const namePattern = /^(?!.*(?:\b\w+\b.*){3})[A-Za-z]+(?: [A-Za-z]+)?$/;
    const phonePattern = /^[1-9][0-9]{9}$/;

    if (!namePattern.test(name)) {
        alert("Name must be alphabetic, allow only one space between first and last name, no special characters, and no repetition of more than three words.");
        return false;
    }

    if (!phonePattern.test(phone)) {
        alert("Phone number must not start with 0 and must not contain any special characters.");
        return false;
    }

    return true;
}