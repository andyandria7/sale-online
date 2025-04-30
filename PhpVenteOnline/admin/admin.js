document.addEventListener('DOMContentLoaded', function () {
    const sections = {
        user: document.querySelector('.lstUser'),
        product: document.querySelector('.lstProduct'),
        vUser: document.querySelector('.valUser'),
        vProduct: document.querySelector('.valProduct')
    };

    const buttons = {
        user: document.getElementById('user'),
        product: document.getElementById('product'),
        vUser: document.getElementById('vUser'),
        vProduct: document.getElementById('vProduct')
    };

    function showSection(sectionName) {
        Object.values(sections).forEach(section => {
            section.classList.remove('active');
            section.style.display = 'none';
        });

        sections[sectionName].classList.add('active');
        sections[sectionName].style.display = 'block';

        Object.values(buttons).forEach(button => {
            button.classList.remove('active-btn');
        });
        buttons[sectionName].classList.add('active-btn');
    }

    buttons.user.addEventListener('click', () => showSection('user'));
    buttons.product.addEventListener('click', () => showSection('product'));
    buttons.vUser.addEventListener('click', () => showSection('vUser'));
    buttons.vProduct.addEventListener('click', () => showSection('vProduct'));

    showSection('user');

    const style = document.createElement('style');
    style.innerHTML = `
        .active-btn {
            background-color: #fc0 !important;
            font-weight: bold;
            border-radius: 5vh;
            color: black !important;
        }
    `;
    document.head.appendChild(style);
});