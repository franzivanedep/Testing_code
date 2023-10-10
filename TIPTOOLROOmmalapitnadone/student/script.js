// Select all add to cart buttons
const addToCartButtons = document.querySelectorAll('.add-to-cart');

// Initialize the cart as an empty array
let cart = [];

// Add event listener to each add to cart button
addToCartButtons.forEach(button => {
  button.addEventListener('click', addToCart);
});

// Function to handle adding items to the cart
function addToCart(event) {
  // Get the item ID from the data attribute
  const itemId = event.target.dataset.itemId;

  // Add the item to the cart array
  cart.push(itemId);

  // Optional: Update the cart count display
  updateCartCount();

  // Optional: Show a confirmation message
  alert('Item added to cart!');
}

// Function to update the cart count display
function updateCartCount() {
  const cartCount = document.getElementById('cart-count');
  cartCount.textContent = cart.length;
}
