<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SCM Gacoan App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-32x32.png">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body>
    <div class="flex-container">
        <div class="flex-item-left"></div>
        <div class="flex-item-right">
        <div class="card" id="card">
        <!-- <div class="card-header">
            <b>Login</b>
        </div> -->
        <div class="card-body">
    <div>
        <img src="img/LogoMieGacoan-removebg-preview.png" class="logo_gacoan">
    </div>
            <form action="/submit_login" method="post">
                <div class="form-email">
                    <label>Email : </label>
                    <input type="text" name="email" class="form-control" placeholder="Masukkkan Email...">
                </div>
                <div class="form-password">
                    <label>Password : </label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password...">
                </div>
            </br>
            <div class="button-bottom">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-danger" type="reset">Cancel</button>
            </form>
            </div>
        </div>
    </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>