function validateForm() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const usernamePattern = /^[^\s]{4,}$/;
    const passwordPattern = /^[^\s]{4,}$/;

    if (!usernamePattern.test(username)) {
        alert("Username must be more than 3 characters long and must not contain spaces.");
        return false;
    }

    if (!passwordPattern.test(password)) {
        alert("Password must be more than 3 characters long and must not contain spaces.");
        return false;
    }

    return true;
}