<?php

use PHPUnit\Framework\TestCase;

require_once '../public-html/components/dao.php';

final class DaoTest extends TestCase {

    protected function setUp() {
        $this->dao = new Dao("Dummy_TA_Ticketing");
        $this->correctEmails = [
            "CooperHazel@example.boisestate.edu",
            "ClaireHannah@example.boisestate.edu",
            "EliEzra@example.boisestate.edu"
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

        $this->assertSame($user["user_id"], "7");
        $this->assertSame($user["permission_id"], "2");
        $this->assertSame($user["email"], "CooperHazel@example.boisestate.edu");
        $this->assertSame($user["password"], "Cooper.Hazel.2");
        $this->assertSame($user["first_name"], "Cooper");
        $this->assertSame($user["last_name"], "Hazel");

        $userId = "7";
        $user = $this->dao->getUser($email);
        
        $this->assertSame($user["user_id"], "7");
        $this->assertSame($user["permission_id"], "2");
        $this->assertSame($user["email"], "CooperHazel@example.boisestate.edu");
        $this->assertSame($user["password"], "Cooper.Hazel.2");
        $this->assertSame($user["first_name"], "Cooper");
        $this->assertSame($user["last_name"], "Hazel");

        $email = "CooperHazel@u.boisestate.edu";
        $user = $this->dao->getUser($email);

        $this->assertEmpty($user);

        $this->assertEmpty($this->dao->getUser());
    }
}