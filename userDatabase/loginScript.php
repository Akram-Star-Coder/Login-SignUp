<?php

if(isset($_POST["submit"])){
    //avant tout on doit creer la connection à la database sinon y'a rien 
    //c'est toujours la premiere chose a faire 
    //pour ceci on doit l'inclure la variable portante la connection 
    include("database.php");
    //c'est ca le fichier ou y a la fameuse variable $connect
    //une fois fini maintenant on a besoin de la data saisi par le user en login
    $username = $_POST["username"];
    $password = $_POST["password"];
    //apres avoir fetché les variables 
    //on doit faire le premier checking c'est le field check
    //checker si les fiels sont remplis avant tout autre checking 
    if(empty($username)){
        header("Location: ../login.php?error=emptyfieldUsername");
        exit();
    }
    else if(empty($password)){
        header("Location: ../login.php?error=emptyfieldPassword&username=".$username);
        exit();
    }
    else{
        //maintenant si les deux sont remplis et que le boutton suubmit est click
        //on doit checker les infos si elles existent dans la database
        //declaration d'une variable requete 
        $requete = "SELECT * FROM usersdata WHERE username = ?";
        //comme toujours on va utiliser les requete securisés nommées statement
        $stmt = mysqli_stmt_init($connect);

        //stmt variable a beosin toujours de la clé de connexion 
        //maintenant passons au checking de la statement
        if(!mysqli_stmt_prepare($stmt,$requete)){
            //donc y a quelquechose qui cloche 
            //car la fonction nous renvoie 1 si c'est bon et !1 = 0 si pas bon
            //la chose qui n'est pas bonne c'est la requete..
            header("Location: ../login.php?error=SQL__ERRoR");
            exit();
        }
        else{
            //donc ca matche
            //on doit chercher les informations data from database
            //si la clé $connect ne marchait pas on ne pourrait pas arriver à cette etape là
            //mainteant pour voir si la data des inputs matche avec la data de la database
            //on utilise la fonction suivante
            mysqli_stmt_bind_param($stmt, 's', $username);//cad on veut voir
            //si y a matching entre le $username et la requete mise en la stmt (requete securisée)
            //maintenant on passe a l'execution 
            mysqli_stmt_execute($stmt);//l'execution de la requete securisée
            //creation d une nouvelle variable pour y stocker y stocker la data de la database
            $resultat = mysqli_stmt_get_result($stmt);
            //cette variable va te donner des donnees incomprehensible ou mal structure
            //donc on va creer une autre variable et en utilisant une fonction 
            //ca transformerait la data rought into a data beautifull in arrays 
            if($row = mysqli_fetch_assoc($resultat)){
                //maintenant qu'on est en cette etape 
                //donc le user existe
                //car le resultat existe == 1 et pointe vers une data 
                //et car $row ==1 
                //maintenant on va prendre le password hashed de la database 
                // et le dehasher 
                //puis voir si ca match avec le password saisi par le user 
                $passcheck = password_verify($password,$row['password']);
                //la variable passcheck serait boolean car la fonction est une fonction de verification
                //cad elle verifie le matching entre 2 variables
                //voila l'utilité de row sans ca on ne pourrait pas utiliser les arrays
                //pour matcher ... ca serait impossible de acceder a la data password
                if($passcheck==false){
                    //le user ne peut pas se connecter 
                    header("Location: ../login.php?error=Incorrect__Password");
                    exit();
                }
                else{
                    //les deux passwords matchent alors
                    //on laisse le user y acceder au site ...
                    //on commence une session 
                    session_start();
                    //creation de la session variable 
                    //et les initialiser au data qu'on a à propos du USER qui s'est connecté
                    $_SESSION["sessionId"] = $row['id'];
                    $_SESSION["sessionUser"] = $row['username'];
                    //on ne va pas mettre une autre variable pour le password dans la session 
                    //car le password est une donnée sensible ! 
                    //on skip le password
                    //une fois les sessiosn créés on veut re-directer le user à la page principale 
                    //et la redirectionse fait avec la fameuse fonction header(Locations.....);
                    header("Location: ../home2.php?success=Loged_In__Successfully");
                    exit();
                }
            }
            else{
                //cad si on obtient rien de la result ==> rien de la row 
                //Autrement dit y'a pas de USER dans la database
                header("Location: ../login.php?No_UseruFound");
                exit();
            }
        }
    }
}
//else on ne fait rien ... logiquement ^^
//ou meme on peut lui mettre un message acces forbidden l'insitant a submitter pour
//acceder au site logiquement parlant

?>
