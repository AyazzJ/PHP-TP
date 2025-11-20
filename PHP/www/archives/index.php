<?php

// Commentaire sur une seule ligne
/*
	sur plusieurs lignes
*/


//Les variables
//Sans espace
//Convention de nommage : camelCase ( snake_case, PascalCase, kebab-case)
//Anglais
//Cohérence du nom
$myFirstName;

//Déclaration dynamique
//Typage dynamique
// Type : string, int, float, bool, null
$myFirstName = "Yves";
$myFirstName = 18;

//Référence / Pointeurs
$age = 18;
$age = "dix huit";
$myAge = &$age;
$myAge = 22;


//Incrémenter ou Décrémenter
$i = 0;
$i++; // post incrémentation
++$i; //pre incrémentation
$i = $i + 1;
$i += 1;

/*
$i=0;
$i++;
echo $i++; //1
echo --$i; //1
echo $i + 1; //2
echo $i += 1; //2
echo $i; //2
echo $i = $i + 1; //3
echo $i; //3
*/

$myFirstName = "Yves";

//echo "Bonjour ";
//echo $myFirstName;

// Concaténation
//echo "Bonjour ".$myFirstName;

// Inclusion mais à éviter trop source d'erreurs
//echo "Bonjour $myFirstName";

//Echaper les caractères
//echo "Aujourd'hui on apprend le \"PHP\" ";


//Conditions : IF
/*
if(condition){
    //Instructions
}else if(condition)
    //une seule instruction
    echo "Une seule instruction";
else{
    //Instruction
}


$age = 18;

if($age == 18)
    echo 'Tout juste majeur';
elseif($age < 18){
    echo 'Mineur';
}else{
    echo 'Majeur';
}

//Conditions : switch
$role = "admin";
switch ($role){
    case "admin" :
        echo "Tu as tous les droits d'administration";
    case "editor" :
        echo "Tu peux modifier tous les contenus";
    case "author" :
        echo "Tu peux modifier tes contenus";
    default :
        echo "Tu peux visualiser le site";
        break;
}


$age = 18;

if($age >= 18){
    echo 'Majeur';
}else{
    echo 'Mineur';
}

//Condition ternaire :
// instruction (condition)? vrai:faux;
echo ($age >= 18)?"Majeur":"Mineur";


// Null coalescent
// Affiche firstname mais si firstname est null affiche yves
echo $firstname??"Anonyme";
//equivalent avec une ternaire :
//echo (is_null($firstname))?"Yves":$firstname;


//Les boucles
//for : Nb de répétition (iteration) connu
//while : Nb de répétition (iteration) inconnu
//do while : au moins 1 iteration
//foreach : Tableaux


for( $cpt=0 ; $cpt<10 ; ++$cpt ){
    echo $cpt;
}

$dice = rand(1, 6);
$cpt = 1;
while ($dice!= 6){
    $dice = rand(1, 6);
    $cpt++;
}
echo $cpt." tentatives";


$cpt = 0;
do{
    $dice = rand(1, 6);
    $cpt++;
}while($dice!= 6);
echo $cpt." tentatives";



//$student = array();
$student = ["LEDOUX","Johan",4];
//$student = [0=>"LEDOUX",1=>"Johan",2=>4];
//echo $student[1];
$student[5]=20;
$student[]=6;
$student[3]="toto";

//echo $student;
echo "<pre>";
print_r($student);

$student = ["lastname"=>"Pierre", "firstname"=>"Martin", "average"=>18];
//Afficher Prénom Nom a une moyenne de 18
echo $student["firstname"]." ".$student["lastname"]." a une moyenne de ".$student["average"];



//Dim : 3D

$iw=[
    "3A"=>[
        "classe 1"=>[],
        "classe 2"=>[
            ["lastname"=>"Pierre", "firstname"=>"Martin", "average"=>18],
        ],
    ],
    "4A"=>[],
    "5A"=>[],
];
//Afficher Martin
echo $iw["3A"]["classe 2"][0]["firstname"];

//Dim :
$array = [
            [],
            [
                [
                    [
                        [
                            ["teste"]
                        ],
                        [
                            []
                        ]
                    ],
                    []
                ]
            ]
        ];


echo "<pre>";
print_r($array);


$firstnames = ["Pierre", "Jean", "Louise","Océane"];
?>

<ul>
    <?php
        foreach ($firstnames as $key=>$firstname){
            echo "<li>".$firstname." (".$key.")</li>";
        }
    ?>
</ul>

*/


$students = [
    [
        "prenom" => "Alice",
        "nom" => "Martin",
        "email" => "alice.martin@example.com",
        "note1" => 14,
        "note2" => 16,
        "age" => 17
    ],
    [
        "prenom" => "Thomas",
        "nom" => "Dupont",
        "email" => "thomas.dupont@example.com",
        "note1" => 12,
        "note2" => 15,
        "age" => 18
    ],
    [
        "prenom" => "Sophie",
        "nom" => "Durand",
        "email" => "sophie.durand@example.com",
        "note1" => 17,
        "note2" => 13,
        "age" => 17
    ],
    [
        "prenom" => "Lucas",
        "nom" => "Petit",
        "email" => "lucas.petit@example.com",
        "note1" => 11,
        "note2" => 14,
        "age" => 16
    ],
    [
        "prenom" => "Emma",
        "nom" => "Lemoine",
        "email" => "emma.lemoine@example.com",
        "note1" => 15,
        "note2" => 18,
        "age" => 17
    ],
    [
        "prenom" => "Nathan",
        "nom" => "Moreau",
        "email" => "nathan.moreau@example.com",
        "note1" => 13,
        "note2" => 12,
        "age" => 16
    ],
    [
        "prenom" => "Camille",
        "nom" => "Laurent",
        "email" => "camille.laurent@example.com",
        "note1" => 16,
        "note2" => 14,
        "age" => 18
    ],
    [
        "prenom" => "Julien",
        "nom" => "Garcia",
        "email" => "julien.garcia@example.com",
        "note1" => 10,
        "note2" => 13,
        "age" => 17
    ],
    [
        "prenom" => "Chloé",
        "nom" => "Roux",
        "email" => "chloe.roux@example.com",
        "note1" => 18,
        "note2" => 17,
        "age" => 16
    ],
    [
        "prenom" => "Antoine",
        "nom" => "Vincent",
        "email" => "antoine.vincent@example.com",
        "note1" => 9,
        "note2" => 11,
        "age" => 18
    ],
    [
        "prenom" => "Léa",
        "nom" => "Fournier",
        "email" => "lea.fournier@example.com",
        "note1" => 13,
        "note2" => 15,
        "age" => 17
    ],
    [
        "prenom" => "Maxime",
        "nom" => "Henry",
        "email" => "maxime.henry@example.com",
        "note1" => 12,
        "note2" => 14,
        "age" => 16
    ],
];

$newStudents=[];

foreach ($students as $student) {
    $average = ($student["note1"]+$student["note2"])/2;
    $average = round($average, 1)*10;
    $newStudents[$average][] = $student;
}

krsort($newStudents);

echo "<pre>";
print_r($newStudents);

?>

<table>
    <thead>
    <tr>
        <th>Rang</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Moyenne</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cpt=1;
    foreach ($newStudents as $average=>$students){

        foreach ($students as $student){

            echo "<tr>";
            echo "<td>".$cpt."</td>";
            echo "<td>".$student["nom"]."</td>";
            echo "<td>".$student["prenom"]."</td>";
            echo "<td>".($average/10)."</td>";
            echo "<tr>";

        }
        $cpt++;
    }

    ?>
    </tbody>
</table>






