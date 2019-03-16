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
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Permissions;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $permissionLevels = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__ . " " . print_r($permissionLevels,1));
        return $permissionLevels;
    }

    /**
     * Attempts to create a permission level. The method will fail if the
     * permisson name already exists in the database.
     * 
     * @param $permissionName - The unique permission name to add to the database.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createPermissionsLevel($permissionName) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Permissions (permission_name)
             VALUES (:permissionName);"
        );
        $query->bindParam(":permissionName", $permissionName);
        if ($query->execute()) {
            return $this->SUCCESS;
        } else {
            return $this->FAILURE;
        }
    }

    /**
     * Delete a permission based on id or name.
     * 
     * @param $permissionId - The id of the permission to delete.
     * @param $permissionName - The name of the permission to delete.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deletePermissionsLevel($permissionId=NULL, $permissionName=NULL) {
        assert($permissionId !== NULL || $permissionName !== NULL);
        $conn = $this->getConnection();
        if ($permissionId !== NULL) {
            $query = $conn->prepare(
                "DELETE FROM Permissions WHERE permission_id = :permissionId"
            );
            $query->bindParam(":permissionId", $permissionId);
        } else if ($permissionName !== NULL) {
            $query = $conn->prepare(
                "DELETE FROM Permissions WHERE permission_name = :permissionName"
            );
            $query->bindParam(":permissionName", $permissionName);
        } else {
            return $this->FAILURE;
        }
        if ($query->execute()) {
            return $this->SUCCESS;
        } else {
            return $this->FAILURE;
        }
    }

}