<?php
class ReviewsController {
    private $reviewsModel;

    /**
     * Constructor that loads the ReviewsModel.
     */
    public function __construct() {
        require_once __DIR__ . '/../Models/ReviewsModel.php';
        $this->reviewsModel = new ReviewsModel();
    }

    /**
     * Handles the submission of a review. Validates the user session, collects input data,
     * and submits the review. Responds with JSON or redirects based on the operation result.
     */
    public function submitReview() {
        // Start session to ensure access to $_SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['userid'] ?? null;
        $productId = $_POST['productid'];
        $rating = $_POST['rating'];
        $text = $_POST['review_text'];

        // Ensure the user is logged in
        if (!$userId) {
            return $this->jsonResponse(['error' => 'User not logged in.']);
        }

        // Attempt to add the review
        $success = $this->reviewsModel->addReview($userId, $productId, $rating, $text);

        if ($success) {
            // Redirect to the product page if the review submission was successful
            header("Location: /api/product?id=" . $productId);
            exit();
        } else {
            // Respond with error if review submission fails
            return $this->jsonResponse(['error' => 'Error submitting review.']);
        }
    }

    /**
     * Sends a JSON response to the client.
     *
     * @param array $data The data to be encoded into JSON and sent to the client.
     */
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}