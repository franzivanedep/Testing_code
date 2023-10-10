const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');

// Create Express app
const app = express();

// Parse incoming JSON data
app.use(bodyParser.json());

// Connect to MongoDB database
mongoose
  .connect('mongodb://localhost:27107/products-db', {
    useNewUrlParser: true,
    useUnifiedTopology: true,
  })
  .then(() => {
    console.log('Connected to the database');
  })
  .catch((error) => {
    console.error('Database connection error:', error);
  });

// Define the product schema and model
const productSchema = new mongoose.Schema({
  name: String,
  image: String,
});

const Product = mongoose.model('Product', productSchema);

// Create a new product
// Create a new product
app.get('/admin/products', async (req, res) => {
  try {
    const { name, image } = req.body;

    const product = new Product({
      name: 'Pogi',
      image: 'images/led_light_2.jpg',
    });

    await product.save();
    res.status(201).json({ message: 'Product created successfully' });
  } catch (error) {
    console.error('Failed to create the product:', error);
    res.status(500).json({ error: 'Failed to create the product' });
  }
});


// Start the server
const port = 3000;
app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
