<?php
/**
 * Class ProductsController
 * Handles product-related operations
 */
class ProductsController {
    private $productsModel;

    /**
     * ProductsController constructor
     * Initializes ProductsModel
     */
    public function __construct() {
        require_once __DIR__ . '/../Models/ProductsModel.php';
        $this->productsModel = new ProductsModel();
    }

    /**
     * Display all products
     */
    public function index() {
        $products = $this->productsModel->fetchProducts();
        
        $pageTitle = 'Products';
        $content = __DIR__ . '/../Views/products.php';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Display a specific product by ID
     * If the product is not found, it shows a 404 error page
     */
    public function showProductById() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->productNotFound();
            return;
        }
        
        $productId = (int)$_GET['id'];
        $sortOrder = $_GET['sort'] ?? 'desc';
    
        $product = $this->productsModel->fetchProductById($productId);
        if (!$product) {
            $this->productNotFound();
            return;
        }

        $pageTitle = $product['NAME'];
        $content = __DIR__ . '/../Views/product.php';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Handle the new product form submission
     */
    public function addProduct() {
        $productData = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'description' => $_POST['description']
        ];

        if ($this->productsModel->addProduct($productData)) {
            header("Location: /?info=productAdd");
        } else {
            header("HTTP/1.0 404 Not Found");
            require __DIR__ . '/../Views/notfound.php';
        }
    }

    /**
     * Show a 404 error page when a product is not found
     */
    private function productNotFound() {
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../Views/notfound.php';
    }
}