<?php 
    session_start();
    require 'func.php';

    if(isset($_SESSION['login'])){
        header('Location: index.php');
        exit;
    }

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            var_dump(md5($password) === $row['password']);
            if(md5($password) === $row['password']){
                $_SESSION['login'] = true;
                header('Location: index.php');
                exit;
            }
        }

        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - libSHELF</title>
    <link rel="icon" href="src/img/logo.ico">
    <link rel="stylesheet" href="style/css/style.css?<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="style/fontawesome-free-5.15.4-web/css/all.css">
</head>
<body class="bg-light">
    <div class="container-fluid the-container">
        <div class="row">
            <!---------ASIDE--------->
            <aside class="aside-menu col-md-2 col-sm-4 d-sm-flex flex-column d-none p-2 col-12" id="aside-menu">
                <button id="close-button"><h4><i class="close-button fas fa-times text-white"></i></h4></button>
                <p class="mt-5 text-light text-center fs-4 fw-normal">Menu</p>
                <div class="container-fluid gap-2 col-sm-11 col-10 p-1 mx-auto">
                    <div class="buttons row">
                    <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="index.php" class="text-decoration-none text-reset"><i class="fas fa-tachometer-alt me-3"></i>Dashboard</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="myprofile.php" class="text-decoration-none text-reset"><i class="fas fa-user me-3"></i>Profile</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="booklist.php" class="text-decoration-none text-reset"><i class="fas fa-book me-3"></i>Book List</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="#" class="text-decoration-none text-reset"><i class="fas fa-sticky-note me-3"></i>My Reviews</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded <?=isset($_SESSION['login']) ? "" : "btn disabled"?>"><a href="./addbook.php" class="text-decoration-none text-reset"><i class="fas fa-plus me-3"></i>Add Books</a></button>
                        <?php if(isset($_SESSION['login'])): ?>
                            <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="logout.php" class="text-decoration-none text-reset"><i class="fas fa-sign-out-alt me-3"></i>Log Out</a></button>
                        <?php else: ?>
                            <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="signin.php" class="text-decoration-none text-reset"><i class="fas fa-sign-in-alt me-3"></i>Log In</a></button>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
            <!---------RIGHT, MAIN SECTION--------->
            <section class="main-section bg-light px-0 col-md-10 col-sm-8" id="main-section">
                <!---------NAV--------->
                <nav class="navbar bg-light px-2 my-1">
                    <div class="nav-left">
                        <button id="hamburger-button">
                            <h4><i class="hamburger-menu fas fa-bars"></i></h4>
                        </button>
                        <div class="d-flex align-items-center ms-2 my-0"><img src="src/img/libSHELF.png" alt="libSHELF logo" style="height: 1.5rem;"><h4 class="title my-auto" style="font-weight: 700;">libSHELF</h4></div>
                    </div>
                    <div class="nav-right">
                        <div class="profile-info">
                            <i class="fas fa-user me-0 me-md-2"></i>
                            <p class="col-md-0 profile-name"><?= isset($_SESSION['login']) ? 'Ara Gamaliel' : 'Guest' ?></p>
                            <div class="dropdwn">
                                <button class="dropdown-profile"><i class="fas fa-chevron-circle-down"></i></button>
                                <div class="dropdown-items p-2 rounded">
                                    <?php if(isset($_SESSION['login'])): ?>
                                        <a href="#" class="text-white text-decoration-none fs-6">See my profile</a>
                                        <hr class="bg-light my-1 mx-auto w-75 text-center">
                                        <a href="#" class="text-white text-decoration-none fs-6">Sign out</a>
                                    <?php else: ?>
                                        <a href="signin.php" class="text-white text-decoration-none fs-6">Log in as Ara Gamaliel</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!---------MAIN CONTENT *EDIT HERE*--------->
                <div class="main-content p-3">
                    <div class="container mx-auto my-auto shadow rounded col-11 col-lg-5 p-5 py-1 bg-danger mb-3" style=" --bs-bg-opacity: .5;">
                        <p class="fs-6 text-center m-0">The website is developed by Ara Gamaliel. Until now, only he who is able to access this website as administrator.</p>
                    </div>
                    <div class="container mx-auto my-auto shadow rounded col-11 col-lg-5 p-5">
                        <h3 class="fw-bolder">Sign In as Ara Gamaliel</h3>
                        <form method="post" action ="">
                            <div class="mb-3">
                                <label for="input-username" name="username" class="form-label fs06">Username</label>
                                <input type="text" class="form-control" id="input-username" name="username" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="input-password" class="form-label fs06">Password</label>
                                <input type="password" class="form-control" id="input-password" name="password">
                            </div>
                            <?php if(isset($error)): ?>
                                <div class="container bg-danger rounded">
                                    <p class="m-1 text-light">Login error! Try again!</p>
                                </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary" name="login">Sign In</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/chart.js"></script>
</body>
</html>