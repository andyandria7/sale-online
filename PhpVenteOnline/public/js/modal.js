document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('cart-modal');
    const openBtn = document.getElementById('open-cart');
    const closeBtn = document.querySelector('.close');
    
    openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = 'block';
    });
    
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    });
    
    const quantityInputs = document.querySelectorAll('.item-quantity-input');
    const cartTotal = document.getElementById('cart-total');

    function updateTotal() {
        let total = 0;
        
        quantityInputs.forEach(input => {
            const productId = input.getAttribute('data-id');
            const newQuantity = parseInt(input.value, 10);
            const itemPrice = parseFloat(input.dataset.price);
            const itemTotal = input.closest('.cart-item').querySelector('.item-total');
            
            if (isNaN(newQuantity) || newQuantity < 1) {
                input.value = 1;
            }

            const newTotal = itemPrice * input.value;
            itemTotal.textContent = `${newTotal.toLocaleString('fr-FR')} Ar`;

            total += newTotal;
        });

        cartTotal.textContent = `${total.toLocaleString('fr-FR')} Ar`;
    }

    quantityInputs.forEach(input => {
        input.addEventListener('change', updateTotal);
    });

    updateTotal();

    // if (clearBtn) {
    //     clearBtn.addEventListener('click', function() {
    //         if (confirm('Voulez-vous vraiment vider votre panier ?')) {
    //             window.location.href = './vente.php?action=clear&redirect=1';
    //         }
    //     });
    // }
});