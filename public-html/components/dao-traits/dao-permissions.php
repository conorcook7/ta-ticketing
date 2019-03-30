<?php
/**
 * Permissions trait to contain the dao functions.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoPermissions {

    /**
     * Get all of the available permission levels.
     * @return $permissionLevels - The array of arrays of permission levels information.
     */
    public function getPermissionLevels() {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT * FROM Permissions;");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $permissionLevels = $query->fetchAll();
            $this->logger->logDebug(__FUNCTION__ . "(): Obtained permission levels");
            return $permissionLevels;
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . "(): Unable to get permission levels");
            $this->logger->logError(__FUNCTION__ . "(): " . $e->getMessage());
            return NULL;
        }
    }

    /**
     * Attempts to create a permission level. The method will fail if the
     * permisson name already exists in the database.
     * 
     * @param $permissionName - The unique permission name to add to the database.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createPermissionsLevel($permissionName) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "INSERT INTO Permissions (permission_name)
                VALUES (:permissionName);"
            );
            $query->bindParam(":permissionName", $permissionName);
            $query->execute();
            $this->logger->logDebug(__FUNCTION__ . "(): Created permission level");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . "(): Unable to create permission level");
            $this->logger->logError(__FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Delete a permission based on id.
     * 
     * @param $permissionId - The id of the permission to delete.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deletePermissionById($permissionId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                    "DELETE FROM Permissions WHERE permission_id = :permissionId"
                );
            $query->bindParam(":permissionId", $permissionId);
            $query->execute();
            $this->logger->logDebug(__FUNCTION__ . "(): Deleted permission by ID");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . "(): Unable to delete permission by ID");
            $this->logger->logError(__FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Delete a permission based on name.
     * 
     *  @param $permissionName - The name of the permission to delete.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deletePermissionByName($permissionName) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "DELETE FROM Permissions WHERE permission_name = :permissionName"
            );
            $query->bindParam(":permissionName", $permissionName);
            $query->execute();
            $this->logger->logDebug(__FUNCTION__ . "(): Deleted permission by name");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . "(): Unable to delete permission by name");
            $this->logger->logError(__FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

}