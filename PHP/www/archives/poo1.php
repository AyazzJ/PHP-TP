<?php
//Class : plan d'une maison
//Convetion de nommage : Pascal Case
class House{
    //Les variables d'une classe = attributs
    public int $wall = 4;
    public int $roof = 1;
    public int $door = 1;
    public int $window = 1;
    public int $fundation = 1;
    private int $stage = 0;
    public int $stairs = 0;

    public function addStage(){
        $this->stage++;
        $this->window++;
        $this->stairs++;
        $this->wall+=4;
    }

}

//$myHouse1 est une instance de la classe House
//$myHouse1 est un objet
$myHouse1 = new House();

$myHouse2 = new House();
$myHouse2->window++;
$myHouse2->addStage();


echo "<pre>";
print_r($myHouse1);
print_r($myHouse2);
//var_dump($myHouse1);




