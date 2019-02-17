<?php

use PHPUnit\Framework\TestCase;

require_once '../public-html/components/dao.php';

final class DaoTest extends TestCase {

    public function testVerifyPassword() {
        $dao = new Dao();
        $this->assertTrue($dao->verifyPassword("Hello4"));
        $this->assertFalse($dao->verifyPassword("hello"));
    }
}