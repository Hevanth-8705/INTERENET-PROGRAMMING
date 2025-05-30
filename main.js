// Basic client-side validation for quantity inputs in menu.php
document.querySelectorAll('input[name="quantity"]').forEach(input => {
  input.addEventListener('input', () => {
    if (input.value < 1) input.value = 1;
  });
});

// Alert on add to cart (if you want to avoid PHP alert and use JS instead)
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', (e) => {
    if (form.querySelector('button[name="add_to_cart"]')) {
      alert('Product added to cart!');
    }
  });
});

// Smooth scroll to top button (optional)
// Create and insert button dynamically
const scrollBtn = document.createElement('button');
scrollBtn.textContent = '↑ Top';
scrollBtn.id = 'scrollTopBtn';
document.body.appendChild(scrollBtn);
scrollBtn.style.cssText = `
  position: fixed;
  bottom: 30px;
  right: 30px;
  padding: 10px 15px;
  background: #6a82fb;
  color: white;
  border: none;
  border-radius: 50%;
  font-size: 18px;
  cursor: pointer;
  display: none;
  z-index: 1000;
`;

scrollBtn.addEventListener('click', () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

window.addEventListener('scroll', () => {
  if (window.scrollY > 300) {
    scrollBtn.style.display = 'block';
  } else {
    scrollBtn.style.display = 'none';
  }
});
