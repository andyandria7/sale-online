document.addEventListener('DOMContentLoaded', function() {
    const pwdInput = document.getElementById('pwd');
    const passVInput = document.getElementById('passV');
    const eyePwd = document.getElementById('eyePwd');
    const eyePassV = document.getElementById('eyePassV');
    
    eyePwd.addEventListener('change', function() {
        pwdInput.type = this.checked ? 'text' : 'password';
    });
    
    eyePassV.addEventListener('change', function() {
        passVInput.type = this.checked ? 'text' : 'password';
    });
    
    // Animation pour les messages d'erreur/confirmation
    const messages = document.querySelectorAll('section > div:first-child div');
    messages.forEach((message, index) => {
        message.style.animationDelay = index * 0.2 + 's';
    });
});