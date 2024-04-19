<?php
require_once 'BaseController.php';

class ReviewsController extends BaseController {
    private $reviewsModel;

    /**
     * Constructor that loads the ReviewsModel.
     */
    public function __construct() {
        parent::__construct();
        $this->reviewsModel = $this->loadModel('Reviews');
    }

    /**
     * Handles the submission of a review. Validates the user session, collects input data,
     * and submits the review. Responds with JSON or redirects based on the operation result.
     */
    public function submitReview() {
        $userId = $_SESSION['userid'] ?? null;
        $productId = $_POST['productid'];
        $rating = $_POST['rating'];
        $text = $_POST['review_text'];

        if (!$userId) {
            return $this->jsonResponse(['error' => 'User not logged in.']);
        }

        $success = $this->reviewsModel->addReview($userId, $productId, $rating, $text);

        if ($success) {
            $this->redirect("/product?id=$productId&info=reviewAdd");
        } else {
            return $this->jsonResponse(['error' => 'Error submitting review.']);
        }
    }

    /**
     * Handles the deletion of a review. Validates the user session, collects input data,
     * and deletes the review. Responds with JSON or redirects based on the operation result.
     */
    public function deleteReview() {
        $reviewId = $_POST['reviewid'] ?? null;
        $userId = $_SESSION['userid'] ?? null;

        if (!$userId || !$reviewId) {
            return $this->jsonResponse(['error' => 'User not logged in or review ID is missing.']);
        }

        $review = $this->reviewsModel->getReviewById($reviewId);
        if (!$review || $review['USERID'] != $userId) {
            return $this->jsonResponse(['error' => 'Review not found or unauthorized access.']);
        }

        $success = $this->reviewsModel->deleteReview($reviewId);
        if ($success) {
            $this->redirect("/product?id=" . $review['PRODUCTID'] . "&info=reviewDelete");
        } else {
            return $this->jsonResponse(['error' => 'Error deleting review.']);
        }
    }
}