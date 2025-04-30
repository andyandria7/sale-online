document.addEventListener('DOMContentLoaded', function() {
    const pwdInput = document.getElementById('pwd');
    const eyeCheckbox = document.getElementById('eye');
    
    eyeCheckbox.addEventListener('change', function() {
        pwdInput.type = this.checked ? 'text' : 'password';
    });
    
    const messages = document.querySelectorAll('section > div:first-child div');
    messages.forEach((message, index) => {
        message.style.animationDelay = index * 0.2 + 's';
    });
});