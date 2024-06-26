<!DOCTYPE html>
<html>
<head>
    <!-- Link to the form CSS file -->
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>
<!-- Product Add Modal -->
<div id="productAddModal" class="modal" style="display:none;">
  <!-- Modal content container -->
  <div class="modal-content">
    <!-- Close button for the modal -->
    <span class="close">&times;</span>
    <div class="form">
        <form method="post" action="/add-product" class="ajax-form">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="categories">Category:</label>
            <select id="categories" name="categoryID" required>
              <?php foreach($categories as $category): ?>
                <option value="<?= $category['CATEGORYID'] ?>"><?= $category['NAME'] ?></option>
              <?php endforeach; ?>
            </select>
            
            <div class="error" style="display: none;"></div>
            <button type="submit">Add Product</button>
        </form>
    </div>
  </div>
</div>
</body>
</html>