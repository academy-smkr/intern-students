<?php

trait bankOperations{
    public $balance = 0;

    public function deposit($amount){
        $this->balance += $amount;
        echo "Deposited : ₹$amount <br>";
    }

    public function withdraw($amount){
        if($amount > 0 && $this->balance >= $amount){
            $this->balance -= $amount;
            echo "Withdrawn : ₹$amount <br>";
        }else{
            echo "Insufficiant balance";
        }
    }

    public function checkBalance(){
        echo "Current balance : " . $this->balance . "<br>";
    }
}

class currentAccount {
    use bankOperations;
}

class savingsAccount {
    use bankOperations;
}

echo "BANK ACCOUNTS";

echo "<hr>";

$ac1 = new currentAccount();
$ac1->deposit(10000);
$ac1->withdraw(999);
$ac1->checkBalance();

echo "<hr>";

$ac2 = new savingsAccount();
$ac2->deposit(1500);
$ac2->withdraw(999);
$ac2->checkBalance();

?>