<?php
use PHPUnit\Framework\TestCase;

class BanksTest extends TestCase
{
    public function testDeposit()
    {
        $bank = new Banks();
        $bank->deposit(100);
        $this->assertEquals(100, $bank->getBalance());
    }

    public function testWithdraw()
    {
        $bank = new Banks();
        $bank->deposit(100);
        $bank->withdraw(50);
        $this->assertEquals(50, $bank->getBalance());
    }

    public function testWithdrawMoreThanBalance()
    {
        $bank = new Banks();
        $bank->deposit(100);
        $this->expectException(Exception::class);
        $bank->withdraw(150);
    }
}
