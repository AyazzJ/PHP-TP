<?php
abstract class Vehicle{

    public function __construct(string $color, int $wheel = 2){
        $this->color = $color;
        $this->wheel = $wheel;
    }

    public function faster(){
        $this->speed += $this->accelerator;
    }
}
class Moto extends Vehicle {
    public function __construct(string $color, int $wheel = 2){
        parent::__construct($color, $wheel);
    }
    public int $wheel = 2;
    public int $motor = 1;
    protected int $speed = 0;
    public int $accelerator = 4;
    public string $color;

}

class Car extends Vehicle {

    public int $wheel = 4;
    public int $motor = 1;
    protected int $speed = 0;
    public int $accelerator = 2;
    public string $color;
}

$myMoto = new Moto("red", 3);
$myMoto->faster();
$myCar = new Car("blue");
$myCar->faster();


echo "<pre>";
print_r($myMoto);
print_r($myCar);