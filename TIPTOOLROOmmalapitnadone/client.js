const axios = require('axios');

axios
  .post('http://localhost:3000/admin/products', {
    name: 'New Product',
    image: 'https://example.com/image.jpg',
  })
  .then((response) => {
    console.log('Product created successfully:', response.data);
  })
  .catch((error) => {
    console.error('Failed to create the product:', error.response.data);
  });
