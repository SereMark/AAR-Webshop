<?php
require_once 'BaseController.php';

class CategoriesController extends BaseController {
    private $CategoriesModel;

    /**
     * CategoriesController constructor
     * Initializes OrderModel
     */
    public function __construct() {
        parent::__construct();
        $this->CategoriesModel = $this->loadModel('Categories');
    }

    /**
     * Add a new category
     */
    public function addCategory() {
        $categoryName = $_POST['categoryName'] ?? null;
        if ($categoryName) {
            if ($this->CategoriesModel->addCategory($categoryName)) {
                $this->redirect('/admin_dashboard?info=categoryAdded');
            } else {
                $this->redirect('/admin_dashboard?info=error');
            }
        } else {
            $this->redirect('/admin_dashboard?info=error');
        }
    }    

     /**
     * Delete a category by its ID
     */
    public function deleteCategory() {
        $categoryId = $_POST['categoryid'] ?? null;
        if ($categoryId && $this->CategoriesModel->deleteCategoryById($categoryId)) {
            $this->redirect('/admin_dashboard?info=delete');
        } else {
            $this->redirect('/admin_dashboard?info=error');
        }
    }
}