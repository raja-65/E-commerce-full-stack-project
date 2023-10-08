<html>
    <body>
        <script>
            function checkLogout(){
                res=confirm("Are you sure want to Logout?");     
                if(res){
                    window.location='../shared/logout.php';
                }          
            }
        </script>    

    </body>
</html>

<?php
session_start();
include "authguard_style.html";
if(!isset($_SESSION['login_status']))
{
    echo "You skipped the Login ...";
    echo "<a href='../shared/login.html'>Login here</a>";
    die;
}

if($_SESSION['login_status']==false)
{
    echo "Login is failed";
    echo "<a href='../shared/login.html'>Login here</a>";
    die;
}

if($_SESSION['usertype']!='Vendor')
{
    echo "Unauthorized Access for this User";
    die;
}
$userid=$_SESSION['userid'];
$username=$_SESSION['username'];
$usertype=$_SESSION['usertype'];

echo "<div class='userbanner'>
        <div class='userid'>#$userid</div>
        <div class='username'>$username</div>
        <div class='usertype'>$usertype</div>
        <div style='cursor:pointer;text-decoration:underline;color:blue'>
            <a onclick='checkLogout()'>Logout</a>
        </div>

</div>";
?>