<?php

/**
 * Courses trait to contain the dao functions for the available courses.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoCourses {

    /**
     * Create a user if they do not exist in the database.
     * 
     * @param $email - The email address of the user to create.
     * @param $firstName - The first name of the user if given, else NULL.
     * @param $lastName - The last name of the user if given, else NULL.
     * @return Returns TRUE if the user was created, else FALSE
     */
    public function createCourse($name, $number, $description) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Available_Courses (course_name, course_number, course_description) " .
            "VALUES (:name, :number, :description);"
        );
        $query->bindParam(":name", $name);
        $query->bindParam(":number", $number);
        $query->bindParam(":description", $description);
        $status = $query->execute();
        if ($status) {
            $this->logger->logDebug(__FUNCTION__ . ": create course successful");
            return $this->SUCCESS;
        }
        return $this->FAILURE;
    }

    /**
     * Get the available course by name.
     * @param $courseName - The course name to search for.
     * @return $availableCourse - The array of course information, else and empty array.
     */
    public function getAvailableCourse($courseName) {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Available_Courses WHERE course_name = :courseName;");
        $query->bindParam(":courseName", $courseName);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        try {
            $status = $query->execute();
            if ($status) {
                $availableCourse = $query->fetch();
                $this->logger->logDebug(__FUNCTION__ . ": " . print_r($availableCourse,1));
                return $availableCourse;
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return NULL;
        }
    }

    /**
     * Get the available course by id
     * 
     * @param $courseId - The available course id
     * @return $availableCourse - The information for the course
     */
    public function getAvailableCourseById($courseId) {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Available_Courses WHERE available_course_id = :courseId;");
        $query->bindParam(":courseId", $courseId);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        try {
            $status = $query->execute();
            if ($status) {
                $availableCourse = $query->fetch();
                $this->logger->logDebug(__FUNCTION__ . ": " . print_r($availableCourse,1));
                return $availableCourse;
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return NULL;
        }
    }

    /**
     * Creates an available course to select from in the UI.
     * 
     * @param $courseNumber - The string version of the course number.
     * @param $courseName - The name of the course.
     * @param $courseSection - The section of the course.
     */
    public function createAvailableCourse($courseNumber, $courseName=NULL, $courseSection=NULL) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Available_Courses (course_number, course_name, section)
             VALUES (:courseNumber, :courseName, :courseSection);"
        );
        $query->bindParam(":courseNumber", $courseNumber);
        $query->bindParam(":courseName", $courseName);
        $query->bindParam(":courseSection", $courseSection);
        if ($query->execute()) {
            return $this->SUCCESS;
        }
        return $this->FAILURE;
    }

    /**
     * Attempts to delete a course from the database.
     * 
     * @param $courseId - The course_id corresponding to the row to delete.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deleteAvailableCourse($courseId) {
        $conn = $this->getConnection();
        $query = $conn->prepare("DELETE FROM Available_Courses WHERE course_id = :courseId;");
        $query->bindParam(":courseId", $courseId);
        if ($query->execute()) {
            return $this->SUCCESS;
        }
        $this->logger->logWarning(__FUNCTION__ . ": Unable to delete available course");
        return $this->FAILURE;
    }

    /**
     * Get all of the available courses.
     * 
     * @param $limit - (optional) A limit to the number of courses returned.
     * @return $availableCourses - The array of arrays of available courses information.
     */
    public function getAvailableCourses($limit=NULL) {
        $conn = $this->getConnection();
        $query = "SELECT * FROM Available_Courses";
        if ($limit == NULL) {
            $query = $conn->prepare($query);
        } else {
            $query .= " LIMIT :limit;";
            $query = $conn->prepare($query);
            $query->bindParam(":limit", $limit, PDO::PARAM_INT);
        }
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $availableCourses = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__ . "()");
        return $availableCourses;
    }

}