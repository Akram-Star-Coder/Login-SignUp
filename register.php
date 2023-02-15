<?php 
    require_once('userDatabase/header.php');   
?>


<div class="container2">
    
    <div class="f2">
        <form action="userDatabase/registerScript.php" method="post">
        <h1>Register</h1>
             <div class="a r">
             <input type="text" name="username" placeholder="Username ">
            </div>
             <div class="bb">
             <input type="password" name="password" placeholder="Password "> 
             </div>
             <div class="bb">
             <input type="password" name="confpass" placeholder="Confirm Password "> 
             </div>
             <div class="c">
             <button type="submit" name="submit">REGISTER</button>
            </div>
            <p>
        Already have an account ? &nbsp;&nbsp;<a href="login.php">Login Here !</a>
    </p>
        </form>
    </div>
    
    
   
</div>





<?php 
    require_once('userDatabase/footer.php');   
?>