<?php 
    include 'userDatabase/header.php';   
?>





<div class="container">
    
    <div class="f2">
        <form action="userDatabase/loginScript.php" method="post">
        <h1>Login</h1>
             <div class="a">
             <input type="text" name="username" placeholder="Username ">
            </div>
             <div class="b">
             <input type="password" name="password" placeholder="Password "> 
             </div>
             <div class="c">
             <button type="submit" name="submit">LOGIN</button>
            </div>
            <p>
        No account ? &nbsp;&nbsp;<a href="register.php">Register Here !</a>
    </p>
        </form>
    </div>
    
    
   
</div>



<?php 
    include 'userDatabase/footer.php' ;   
?>