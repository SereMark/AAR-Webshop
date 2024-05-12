<?php
require_once 'BaseController.php';

class ProductsController extends BaseController {
    private $productsModel;
    private $categoriesModel;

    /**
     * ProductsController constructor
     * Initializes ProductsModel and CategoriesModel
     */
    public function __construct() {
        parent::__construct();
        $this->productsModel = $this->loadModel('Products');
        $this->categoriesModel = $this->loadModel('Categories');
    }

    /**
     * Display products based on category or search term
     */
    public function displayProducts() {
        $categoryId = $_GET['category'] ?? null;
        $searchTerm = $_GET['q'] ?? null;
        $categories = $this->categoriesModel->fetchCategories();
        $newestProducts = $this->productsModel->fetchNewestProducts();
        $productSuggestions = [];
        $topCategoryProducts = [];
        if (isset($_SESSION['userid'])) {
            $productSuggestions = $this->productsModel->getProductSuggestionsByUserId($_SESSION['userid']);
        }
        if (!empty($searchTerm)) {
            $products = $this->productsModel->searchProducts($searchTerm);
            $pageTitle = 'Search results for: ' . $searchTerm;
        } else {
            $products = $categoryId ? $this->productsModel->fetchProductsByCategory($categoryId) : $this->productsModel->fetchProducts();
            $topCategoryProducts = $categoryId ? $this->productsModel->getTopProductsByCategory($categoryId) : [];
            $pageTitle = $categoryId ? $this->categoriesModel->fetchCategoryById($categoryId)['NAME'] : 'Products';
        }

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

        $category = null;
        if (isset($product['CATEGORYID'])) {
            $category = $this->categoriesModel->fetchCategoryById($product['CATEGORYID']);
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
            'description' => $_POST['description'],
            'categoryID' => $_POST['categoryID'],
            'userid' => $_SESSION['userid']
        ];

        if (strlen($productData['name']) > 50) {
            $this->jsonResponse(['error' => 'Product name exceeds the maximum length of 50 characters.']);
            exit;
        }

        if (!preg_match('/^\d{1,8}(\.\d{1,2})?$/', $productData['price'])) {
            $this->jsonResponse(['error' => 'Price must be a number with up to 8 digits before the decimal point and 2 digits after the decimal point.']);
            exit;
        }

        if ($this->productsModel->addProduct($productData)) {
            return $this->jsonResponse(['redirect' => '/?info=productAdd']);
        } else {
            $this->renderNotFound();
        }
    }

    /**
     * Display all products added by the current user
     */
    public function showUserProducts() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }

        $products = $this->productsModel->fetchProductsByUserId($userId);
        
        $pageTitle = 'My Products';
        $content = __DIR__ . '/../Views/productList.php';
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Handle the deletion of a product
     */
    public function deleteProduct() {
        $productId = $_POST['productid'] ?? null;
        $returnUrl = $_POST['return'] ?? '/?info=error';

        if ($productId && $this->productsModel->deleteProduct($productId)) {
            $this->redirect($returnUrl . '?info=delete');
        } else {
            $this->redirect($returnUrl . '?info=error');
        }
    }

    /**
     * Handle the deletion of all products added by the current user
     */
    public function deleteAllUserProducts() {
        $userId = $_SESSION['userid'] ?? null;
        if (!$userId) {
            $this->redirect('/?info=LoginRequired');
        }

        $success = $this->productsModel->deleteAllProductsByUserId($userId);

        if ($success) {
            $this->redirect('/products?info=delete');
        } else {
            $this->redirect('/products?info=error');
        }
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