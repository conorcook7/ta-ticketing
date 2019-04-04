<?php
/**
 * FAQs trait to contain the dao functions.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoFaq {

    /**
     * Create a frequently asked quetion.
     * 
     * @param $adminUserId - The admin user id that created the FAQ.
     * @param $question - The question for the FAQ.
     * @param $answer - The answer that the admin would like to provide.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createFAQ($adminUserId, $question, $answer) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "INSERT INTO Frequently_Asked_Questions (admin_user_id,
                question, answer) VALUES (:adminUserId, :question, :answer);"
            );
            $query->bindParam(":adminUserId", $adminUserId);
            $query->bindParam(":question", $question);
            $query->bindParam(":answer", $answer);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Created FAQ");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to create FAQ");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Delete a frequently asked question.
     * 
     * @param $faqId - The id of the FAQ to delete
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deleteFAQ($faqId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "DELETE FROM Frequently_Asked_Questions WHERE faq_id = :faqId;"
            );
            $query->bindParam(":faqId", $faqId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Deleted FAQ");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to delete FAQ");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Update a frequently asked question.
     * 
     * @param $faqId - The ID of the FAQ to update.
     * @param $adminUserId - The user_id of the admin who is updating.
     * @param $question - The new question phrase.
     * @param $answer - The new answer phrase.
     * @return Returns TRUE if the update was successful, else FALSE.
     */
    public function updateFAQ($faqId, $adminUserId, $question, $answer) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "UPDATE Frequently_Asked_Questions SET 
                    admin_user_id = :adminUserId,
                    question = :question, 
                    answer = :answer
                    WHERE faq_id = :faqId;"
            );
            $query->bindParam(":faqId", $faqId);
            $query->bindParam(":adminUserId", $adminUserId);
            $query->bindParam(":question", $question);
            $query->bindParam(":answer", $answer);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Updated FAQ");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to update FAQ");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Get all of the frequently asked questions.
     * 
     * @param $limit - (optional) A limit to the number of FAQs to return.
     * @return $FAQs - The array of arrays of FAQs information.
     */
    public function getFAQs($limit=NULL) {   
        try {
            $conn = $this->getConnection();
            $query = "SELECT * FROM Frequently_Asked_Questions";
            if ($limit == NULL) {
                $query = $conn->prepare($query);
            } else {
                $query .= " LIMIT :limit;";
                $query = $conn->prepare($query);
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Executed query");
            $FAQs = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all data");
            return $FAQs;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get FAQs");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return NULL;
        }
    }

}