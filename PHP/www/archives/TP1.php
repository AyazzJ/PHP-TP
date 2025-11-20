<?php
/*
Tout le code doit se faire dans ce fichier PHP

Réalisez un formulaire HTML contenant :
- firstname
- lastname
- email
- pwd
- pwdConfirm

Créer une table "user" dans la base de données, regardez le .env à la racine et faites un build de docker
si vous n'arrivez pas à les récupérer pour qu'il les prenne en compte

Lors de la validation du formulaire vous devez :
- Nettoyer les valeurs, exemple trim sur l'email et lowercase (5 points)
- Attention au mot de passe (3 points)
- Attention à l'unicité de l'email (4 points)
- Vérifier les champs sachant que le prénom et le nom sont facultatifs
- Insérer en BDD avec PDO et des requêtes préparées si tout est OK (4 points)
- Sinon afficher les erreurs et remettre les valeurs pertinantes dans les inputs (4 points)

Le design je m'en fiche mais pas la sécurité

Bonus de 3 points si vous arrivez à envoyer un mail via un compte SMTP de votre choix
pour valider l'adresse email en bdd


Pour le : 22 Octobre 2025 - 8h
M'envoyer un lien par mail de votre repo sur y.skrzypczyk@gmail.com
Objet du mail : TP1 - 2IW3 - Nom Prénom
Si vous ne savez pas mettre votre code sur un repo envoyez moi une archive
*/


//Est-ce que l'utilisateur a validé le form ?
if($_SERVER["REQUEST_METHOD"] == "POST"
    && count($_POST)==5
    && isset($_POST["firstname"])
    && isset($_POST["lastname"])
    && !empty($_POST["email"])
    && !empty($_POST["pwd"])
    && !empty($_POST["pwdConfirm"])
){

    $firstname = ucwords(strtolower(trim($_POST["firstname"])));
    $lastname = strtoupper(trim($_POST["lastname"]));
    $email = strtolower(trim($_POST["email"]));

    $errors = [];

    try{
        $pdo = new PDO( 'pgsql:dbname=devdb;host=db' , 'devuser', 'devpass');
    }catch(Exception $e){
        die("Erreur SQL :".$e->getMessage());
    }

    if(strlen($firstname)==1){
        $errors[]="Le prénom doit faire au moins 2 caractères";
    }
    if(strlen($lastname)==1){
        $errors[]="Le nom doit faire au moins 2 caractères";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[]="Le format de l'email est invalide";
    }else{
        $sql = 'SELECT id FROM public."user" WHERE email = :email';
        $queryPrepared = $pdo->prepare($sql);
        $queryPrepared->execute(["email"=>$email]);
        $result = $queryPrepared->fetch();
        if(!empty($result)){
            $errors[]="L'email existe déjà";
        }
    }


    if(strlen($_POST["pwd"])<8 ||
        !preg_match('#[A-Z]#', $_POST["pwd"]) ||
        !preg_match('#[a-z]#', $_POST["pwd"]) ||
        !preg_match('#[0-9]#', $_POST["pwd"])
    ){
        $errors[]="Le mot de passe doit faire au moins 8 caractères avec une minuscule, une majuscule et un chiffres";
    }

    if($_POST["pwd"] != $_POST["pwdConfirm"]){
        $errors[]="Le mot de passe de confirmation ne correspond pas";
    }

    if(empty($errors))
    {

        $pwdHashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO public."user"  (firstname, lastname, email, pwd, date_created)
        VALUES ( :firstname , :lastname , :email , :pwd , \''.date("Ymd").'\' )';

        $queryPrepared = $pdo->prepare($sql);
        $queryPrepared->execute([
            "firstname"=>$firstname,
            "lastname"=>$lastname,
            "email"=>$email,
            "pwd"=>$pwdHashed
        ]);


    }



}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TP1 PHP</title>
    </head>
    <body>

    <?php
        if(!empty($errors)){
            echo "<pre>";
            print_r($errors);
            echo "</pre>";
        }
    ?>


    <form method="POST" action="TP1.php">
        <input type="text" value="<?= $_POST["firstname"]??"" ?>" name="firstname" placeholder="First Name"><br>
        <input type="text" value="<?= $_POST["lastname"]??"" ?>"  name="lastname" placeholder="Last Name"><br>
        <input type="email" value="<?= $_POST["email"]??"" ?>"  required name="email" placeholder="Email"><br>
        <input type="password" required name="pwd" placeholder="Password"><br>
        <input type="password" required name="pwdConfirm" placeholder="Confirm Password"><br>
        <input type="submit" value="Register">
    </form>

    </body>
</html>


