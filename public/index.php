<html>
<head>
</head>
<body>
    <?php
    require_once __DIR__ . '/../src/Models/ProductsModel.php';
    $productsModel = new ProductsModel();
    $products = $productsModel->fetchProducts();
    try {
        $products = $productsModel->fetchProducts();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        die();
    }
    ?>
    <table border="0">
        <?php
        if (!empty($products)) {
            echo '<tr>';
            foreach (array_keys($products[0]) as $field) {
                echo '<td>' . $field . '</td>';
            }
            echo '</tr>';
            foreach ($products as $row) {
                echo '<tr>';
                foreach ($row as $item) {
                    echo '<td>' . htmlspecialchars($item) . '</td>';
                }
                echo '</tr>';
            }
        }
        ?>
    </table>
</body>
</html>