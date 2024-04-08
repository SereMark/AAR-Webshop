<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link rel="stylesheet" href="assets/css/shared.css">
</head>
<body>
    <?php
    require_once __DIR__ . '/../src/Models/ProductsModel.php';

    function fetchProductsSafely() {
        $productsModel = new ProductsModel();
        try {
            return $productsModel->fetchProducts();
        } catch (Exception $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }

    $products = fetchProductsSafely();
    ?>

    <table>
        <thead>
            <?php if (!empty($products)): ?>
                <tr>
                    <?php foreach (array_keys($products[0]) as $field): ?>
                        <th><?php echo htmlspecialchars($field); ?></th>
                    <?php endforeach; ?>
                </tr>
        </thead>
        <tbody>
                <?php foreach ($products as $row): ?>
                    <tr>
                        <?php foreach ($row as $item): ?>
                            <td><?php echo htmlspecialchars($item); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>