<?php

//la premiere des chose est de checker si le USER a cliqué le bouton submit
//sinon sans checking on ne saurait pas 
//toujours pour le checking d'un bouton s'il est cliqué on utilise le isset()
if(isset($_POST["submit"])){
    //isset == true 
    //submit cliqué
    //mtn on a besoin de la variable $connect appartenante a database.php
    //attention on en fait l appel que si post est vraiment submit
    //on ne peut pas leur donner acces si il n a pas cliqué 
    include("database.php");
    //maintenant qu'on a acces à la variable $connect
    //on passe à chercher(fetch) la data saisie par le USER en form
    //on sait que $_POST a 4 variable ["username","pass","confpass","submit"]
    //on fait une simple affectation
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confpassword = $_POST["confpass"];

    //maintenant le 1st Checking c'est de checker si les champs ne sont
    //pas NULL vide (ceci si on n'a pas mis required en inputs)
    if(empty($username)||empty($password)||empty($confpassword)){
        //si un seul champ est vide on se redirect vers la meme page
        //on utiliserait la function 
        header("Location: ../register.php?error=emptyfield&username=".$username);
        //cette fonction lance une error et nous redirecte vers la mm page
        //lorsqu'on se redirect vers la meme page 
        //maintenant que l'erreur s'est affiché a l user
        //on repart a header.php et on ajoute ce script en includes
        exit();
        //en mettant cette exit function elle termine le script 
        //cad meme si tu mets qq chose apres elle ca ne s'executerait pas
        //et comme ca on garde les choses professionelles
    }
    else{
        //cad si aucun field n'est vide
        //on continue notre chemin 
        if(!preg_match("/^[a-zA-Z0-9]*/",$username)){
            header("Location: ../register.php?error=InvalidUsername&username=".$username);
            exit();
        }
        //maintenant checking de password si ils osnt egaux
        else if($password !== $confpassword){
            header("Location: ../register.php?error=Password_Not_Matching&username=".$username);
            exit();
            //on a checké le type et la valeur 
        }

        else{
            //le dernier checking est de checker si le user existe deja
            //dans notre base de donnée
            //si il existe on lance error
            //sinon on l'ajoute dans notre base de donnée
            //pour checker on a besoin d'abords de recevoir la base de donnedes users
            //et pour ceci on va declaré une variable qui serait egale a une requete 
            //pour apres l'utiliser
            $requete = "SELECT * FROM usersdata WHERE username = ?";
            $stmt = mysqli_stmt_init($connect);
            if(!mysqli_stmt_prepare($stmt,$requete)){
                header("Location: ../register.php?error=SQL_ERROR1");
                exit();
            }
            else{
                //la statement est préparée pour l'execution 
                //si ca marche on prend les infos que le user nous a donné
                //et on les lies ( to bind ) 
                mysqli_stmt_bind_param($stmt,'s',$username);
                mysqli_stmt_execute($stmt);//elle execute une statement (requete developé) 
                mysqli_stmt_store_result($stmt);
                //cette fct prend le resultat a partir de la database
                //et elle le sauvegarde en la variable statement
                $rowCount = mysqli_stmt_num_rows($stmt);
                //cette variable aurait 1 ou 0 
                //1 si le username est deja existant et 0 sinon
                if($rowCount > 0){
                    //user already exist ==> lancer une error avec redirect
                    header("Location: ../register.php?error=User_Already_Exists".$username);
                    exit();
                }else{
                    //le user n'existe pas 
                    //donc oui on peut maintenant l'inserer dans notre database geniunly
                    //declaration d une autre variable requete2
                    $requete = "INSERT INTO usersdata (`username`, `password`) VALUES (?,?)";
                    //on a mis ? , ? car on utilise les statement 
                    //or si on utilisait les requete simple sql 
                    //on allait mettre $username et $password
                    $stmt = mysqli_stmt_init($connect);
                    //encore une etape de checking si ca match avec le prepare
                    // la fonction .._prepare fait le matchingchecking entre 
                    //la requete sql simple et la requete securisé (statement)  
                    if(!mysqli_stmt_prepare($stmt,$requete)){
                        //si ca match pas ==> lance une erreur 
                        header("Location: ../register.php?error=SQL_ERROR2");
                        exit();
                    }
                    else{
                        //si ca match 
                        //on hash le password to securise it 
                        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                        //on va hasher les password avec bcript qui se caracterise par le update 
                        //automatic et sequentiel donc plus de securité
                        mysqli_stmt_bind_param($stmt,'ss',$username, $hashedPass);
                        //on a mis double ss car on ne peut pas mettre "s" "s"
                        
                        // cette fonction ==> mysqli_stmt_store_result($stmt); n'est utilisé que si on veut 
                        //fetcher des infos (chercher) de la database
                        //or nous maintenant on veut inserer !
                        mysqli_stmt_execute($stmt);
                        
                        //in fact on peut meme laisser les memes parametre des stmt et requete
                        //et les ecraser sans redeclarer de nouvelle variables stmt(i)
                        //en ce point là la data du user va etre inséré dans la database !! Youpy ^^
                        //une fois qu'il est inseré on doit le re-directer vers la page login 
                        //afin qu'il se log in et entre au site ...
                        //et le redirecting serait avec un message success et pas error 
                        //c'est simple on utilise la fonction header('Location: ....');
                        header("Location: ../login.php?success=User_REGISTRED_Successfully"); 
                        //comme tu remarques on a pas mis de exit();
                        //car si on la met on aura comme erreur ===> UNREACHABLE CODE DETECTED
                        //et donc on ne pourrait pas close le $stmt et $connect variables
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($connect);
        //apres avoir inserer on deconnecte la connection avec la database... 
    }
}
/*
else{
    //isset == false
    //submit non cliqué
    //on va rien faire 
}
*/







