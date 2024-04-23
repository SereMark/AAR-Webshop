<?php
require_once 'BaseController.php';

class ProductsController extends BaseController {
    private $productsModel;

    /**
     * ProductsController constructor
     * Initializes ProductsModel
     */
    public function __construct() {
        parent::__construct();
        $this->productsModel = $this->loadModel('Products');
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
            $this->redirect('/?info=productAdd');
        } else {
            $this->renderNotFound();
        }
    }

    /**
     * Display all products added by the current user
     */
    public function showUserProducts() {
        // $userId = $_SESSION['userid'] ?? null;
        // if (!$userId) {
        //     $this->redirect('/');
        // }

        // $products = $this->productsModel->fetchProductsByUserId($userId);
        // $pageTitle = 'My Products';
        // $content = __DIR__ . '/../Views/productList.php';
        // require __DIR__ . '/../Views/layout.php';
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../Views/notfound.php';
    }

    /**
     * Show a 404 error page when a product is not found
     */
    private function productNotFound() {
        $this->renderNotFound();
    }

    /**
     * Helper method to render a 404 Not Found page.
     */
    private function renderNotFound() {
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../Views/notfound.php';
    }
}