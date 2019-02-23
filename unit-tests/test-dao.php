<?php

use PHPUnit\Framework\TestCase;

require_once '../public-html/components/dao.php';

final class DaoTest extends TestCase {

    protected function setUp() {
        $this->dao = new Dao("Dummy_TA_Ticketing");
        $this->correctEmails = [
            "CooperHazel@example.boisestate.edu",
            "EzraCooper@example.boisestate.edu"
        ];
        $this->incorrectEmails = [
            "HaydenPhothong@u.boisestate.edu",
            "MalikHerring@u.boisestate.edu",
            "MichaelSanchez563@u.boisestate.edu",
            "ConorCook@u.boisestate.edu"
        ];
    }

    public function testDao() {
        $this->assertInstanceOf(Dao::class, $this->dao, "Dao constructor does not return a Dao object.");
    }

    public function testConnection() {
        $this->assertInstanceOf(PDO::class, $this->dao->getConnection(), "Unable to get connection from Dao.");
    }

    public function testVerifyPassword() {
        $this->assertTrue($this->dao->verifyPassword("Hello4"), "Password 'Hello4' does not verify");
        $this->assertFalse($this->dao->verifyPassword("hello"), "Password 'hello' verified.");
        $this->assertFalse($this->dao->verifyPassword(""), "Password '' verified.");
        $this->assertFalse($this->dao->verifyPassword("1234567"), "Password '1234567' verified.");
    }

    public function testUserExists() {
        foreach ($this->correctEmails as $email) {
            $this->assertTrue($this->dao->userExists($email), "The email '{$email}' should exist.");
        }
        foreach ($this->incorrectEmails as $email) {
            $this->assertFalse($this->dao->userExists($email), "The email '{$email}' should not exist.");
        }
    }

    public function testGetUser() {
        $email = "CooperHazel@example.boisestate.edu";
        $user = $this->dao->getUser($email);

        $this->assertSame($user["user_id"], "5");
        $this->assertSame($user["permission_id"], "2");
        $this->assertSame($user["online"], "0");
        $this->assertSame($user["email"], "CooperHazel@example.boisestate.edu");
        $this->assertSame($user["password"], "Cooper.Hazel.2");
        $this->assertSame($user["first_name"], "Cooper");
        $this->assertSame($user["last_name"], "Hazel");

        $userId = "5";
        $user = $this->dao->getUser($email);
        
        $this->assertSame($user["user_id"], "5");
        $this->assertSame($user["permission_id"], "2");
        $this->assertSame($user["online"], "0");
        $this->assertSame($user["email"], "CooperHazel@example.boisestate.edu");
        $this->assertSame($user["password"], "Cooper.Hazel.2");
        $this->assertSame($user["first_name"], "Cooper");
        $this->assertSame($user["last_name"], "Hazel");

        $email = "CooperHazel@u.boisestate.edu";
        $user = $this->dao->getUser($email);

        $this->assertEmpty($user);

        $this->assertEmpty($this->dao->getUser());
    }

    public function testGetQueueNumber() {
        // All of the online ids
        $userIds = [37, 193, 118, 15, 75, 106, 133, 143, 135, 48, 63, 72, 178, 
                    61, 167, 163, 65, 35, 23, 152, 182, 120, 39, 161, 62, 93, 
                    58, 46, 70, 95, 30, 45, 171, 198, 34, 131, 53, 28, 94, 188, 
                    73, 126, 123, 57, 115,  1, 137,  6, 130, 136, 91, 69, 150, 
                    116, 156, 164, 82, 192, 10, 97, 38, 80, 71, 125, 99, 11, 2, 
                    168, 138,  3, 189, 157, 147, 105, 145, 114, 84, 32, 77,
                    173, 166, 44, 180, 158, 194, 195, 100, 127, 24, 117, 191,
                    54, 25, 21, 56, 184, 31, 177, 101, 18, 49, 146];
        for ($i = 0; $i < count($userIds); $i++) {
            $this->assertSame($this->dao->getQueueNumber($userIds[$i]), ($i+1));
        }
        
        // All of the offline ids
        $userIds = [169, 86, 104, 40, 20,  98, 134, 41, 122, 160, 17, 68, 148, 
                    110, 4, 197, 22, 29, 196, 165, 26, 187, 185, 108, 81, 142, 
                    179, 50, 55, 113, 8, 112, 128, 162, 129, 90, 103, 172, 36, 
                    111, 67, 183, 27, 176, 153, 52, 119, 89, 85, 43, 107, 9, 
                    124, 16, 79, 109, 96, 42, 186, 170, 155, 12, 154, 149, 83,
                    151, 74, 121, 159, 64, 88, 7, 5, 60, 92, 175, 139, 140, 78, 
                     47, 13, 190, 14, 76, 33, 144, 102, 19, 51, 141, 66, 87,
                     59, 174, 132, 181];
        for ($i = 0; $i < count($userIds); $i++) {
            $this->assertSame($this->dao->getQueueNumber($userIds[$i]), -1);
        }
        
    }
}