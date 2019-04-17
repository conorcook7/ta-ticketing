<?php

/**
 * Blacklist trait to deal with users. The blacklist is going to deal with
 * users at first, however, it may be expanded later.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoBlacklist {

    /**
     * Create a blacklist entry in the database.
     * 
     * @param $email - The email address to blacklist
     * @return Returns TRUE on successful creation, else FALSE.
     */
    function createBlacklistEntry($userId, $email) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("INSERT INTO Blacklist (blacklist_email, creator_user_id) VALUES (:blacklistEmail, :userId);");
            $query->bindParam(":blacklistEmail", $email);
            $query->bindParam(":userId", $userId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Created new blacklist entry.");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create new blacklist entry.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Get all of the blacklist entries from the database.
     * This function is mainly used to populate the admin page.
     * 
     * @return $blacklistEntries - The list of blacklisted email addresses, else FALSE.
     */
    function getBlacklistEntries() {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT * FROM Blacklist LEFT JOIN Users ON Blacklist.creator_user_id = Users.user_id;");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $blacklistEntries = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Retrieved all blacklist entries");
            return $blacklistEntries;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create new blacklist entry.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Update an email address that is in the blacklist.
     * 
     * @param $userId - The user changing the blacklist entry
     * @param $blacklistId - The blacklist entry to update
     * @param $email - The new email address
     * @return Returns TRUE if the email was updated, else FALSE
     */
    function updateBlacklistEntry($userId, $blacklistId, $email) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("UPDATE Blacklist SET blacklist_email = :blacklistEmail, creator_user_id = :userId WHERE blacklist_id = :blacklistId;");
            $query->bindParam(":blacklistEmail", $email);
            $query->bindParam(":userId", $userId);
            $query->bindParam(":blacklistId", $blacklistId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Updated a blacklist entry email address.");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to update a blacklist entry email address.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Remove an email from the blacklist by ID
     * 
     * @param $blacklistId - The blacklist_id of the entry to delete
     * @param $resetPermissions - Reset the permissions of the email address to 1
     * @return Returns TRUE if the deletion was successful, else FALSE
     */
    function deleteBlacklistEntryById($blacklistId, $resetPermissions=FALSE) {
        try {
            $conn = $this->getConnection();
            if ($resetPermissions) {
                // Get the email address
                $query = $conn->prepare("SELECT blacklist_email AS email FROM Blacklist WHERE blacklist_id = :blacklistId");
                $query->bindParam(":blacklistId", $blacklistId);
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();
                $email = $query->fetch()["email"];

                // Get the permission id
                $query = $conn->prepare(
                    "SELECT permission_id FROM Permissions
                    WHERE permission_name = 'USER'"
                );
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();
                $permissionId = $query->fetch()["permission_id"];

                // Update the permissions of the email address
                $query = $conn->prepare(
                    "UPDATE Users SET permission_id = :permissionId
                    WHERE email = :email"
                );
                $query->bindParam(":permissionId", $permissionId);
                $query->bindParam(":email", $email);
                $query->execute();
            }

            // Delete the blacklist entry
            $query = $conn->prepare("DELETE FROM Blacklist WHERE blacklist_id = :blacklistId;");
            $query->bindParam(":blacklistId", $blacklistId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Deleted a blacklist entry.");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to delete a blacklist entry.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Remove an email from the blacklist by email
     * 
     * @param $email - The email to remove from the blacklist
     * @param $resetPermissions - Reset the permissions of the email address to 1
     * @return Returns TRUE if the deletion was successful, else FALSE
     */
    function deleteBlacklistEntryByEmail($email, $resetPermissions=FALSE) {
        try {
            $conn = $this->getConnection();
            if ($resetPermissions) {
                // Get the permission id
                $query = $conn->prepare(
                    "SELECT permission_id FROM Permissions
                    WHERE permission_name = 'USER'"
                );
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();
                $permissionId = $query->fetch()["permission_id"];

                // Update the permissions of the email address
                $query = $conn->prepare(
                    "UPDATE Users SET permission_id = :permissionId
                    WHERE email = :email"
                );
                $query->bindParam(":permissionId", $permissionId);
                $query->bindParam(":email", $email);
                $query->execute();
            }
            $query = $conn->prepare("DELETE FROM Blacklist WHERE blacklist_email = :blacklistEmail;");
            $query->bindParam(":blacklistEmail", $email);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Deleted a blacklist entry.");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create new blacklist entry.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Check if the email address is blacklisted
     * 
     * @param $email - The email to check for a blacklist entry
     * @return Returns TRUE if the email is in the blacklist, else FALSE
     */
    function isBlacklisted($email) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT COUNT(*) FROM Blacklist WHERE blacklist_email = :blacklistEmail;");
            $query->bindParam(":blacklistEmail", $email);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $result = $query->fetch()["COUNT(*)"];
            if ($result) {
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Blacklisted email found.");
                return TRUE;
            } else {
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Email is not blacklisted.");
                return FALSE;
            }
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to check if the email is blacklisted.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Treating the email as non-blacklisted.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }
}