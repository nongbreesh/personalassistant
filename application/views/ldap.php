<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to CodeIgniter</title>


    </head>
    <body>



    </body>
    <script>
        var Data = {};
                try
        {
        var Information = new ActiveXObject("WScript.Network");
                Data.Username = Information.UserName;
                Data.Computername = Information.ComputerName;
                Data.Domain = Information.UserDomain;
                $.post("/ldap/ajax/login", Data, fucntion(object){
                if (object.success)
                {
                document.location = "/"; //Will automatically start session.
                } else
                {
                document.location = "/ldap/faild/"; //general login page
                }
                });
        } catch (e)
        {
        document.location = "/ldap/faild/"; //general login page
        }
    </script>
</html>