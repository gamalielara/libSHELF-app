<?php 
session_start();
    include 'func.php';
    if(!isset($_GET['id'])){
        header("Location: index.php");
        exit;
    }
    $id = $_GET['id'];
    $book = query("SELECT * FROM booklist WHERE id = '$id'")[0];
    $thisFile = 'bookreview.php?id='.$id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['Title'] ?> review - libSHELF</title>
    <link rel="icon" href="src/img/logo.ico">
    <link rel="stylesheet" href="style/css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="style/css/booklist.css?<?php echo time(); ?>">
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
                <div class="container-fluid gap-2 col-sm-11 col-10 mx-auto">
                    <div class="buttons row">
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="index.php" class="text-decoration-none text-reset"><i class="fas fa-tachometer-alt me-3"></i>Dashboard</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="myprofile.php" class="text-decoration-none text-reset"><i class="fas fa-user me-3"></i>Profile</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="booklist.php" class="text-decoration-none text-reset"><i class="fas fa-book me-3"></i>Book List</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded btn disabled"><a href="#" class="text-decoration-none text-reset"><i class="fas fa-sticky-note me-3"></i>My Reviews</a></button>
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
            <section class="main-section bg-light px-0 col-md-10 col-sm-8">
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
                <div class="main-content p-4">
                    <div class="book-info col-lg-6 col-12 m-auto">
                        <div class="row m-auto">
                            <div class="col-lg-3 col-12 m-auto">
                                <img src="src/img/<?=$book['BookCover']?>" alt="" class="w-100 book-cover m-auto">
                            </div>
                            <div class="col-lg-9 col-12 m-auto">
                                <h3><?= $book['Title'] ?></h3>
                                <p class="fs-6">Pages: <?= $book['Pages'] ?></p>
                                <p class="fs-6">Date Read: <?= $book['DateRead'] ?></p>
                                <p class="fs-6">My Rating: <?= $book['Rating'] ?>/5<i class="fas fa-star mx-1"></i></p>
                            </div>
                            <a href="myreviews.php" class="text-decoration-none text-primary"><i class="fas fa-arrow-left mt-3"></i> My Reviews</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="full-review col-lg-6 col-12 mx-auto">
                            <p class="fs-6">
                                <?= stripslashes($book['FullReview']) ?>
                            </p>
                            <form action="" method="post">
                                <button type="submit" name="editreview" class="btn btn-info text-light <?=isset($_SESSION['login']) ? "" : "disabled" ?>"><i class="fas fa-pencil-alt mx-1"></i>Edit This Review</button> 
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-------EDIT POPUP BOX -------->
    <div class="modal fade" id="pop-up-box-edit" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="<?=$thisFile?>"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 3%;"></button></a>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?=$book['id']?>">
                        <div class="form-floating my-3">
                            <h3>Edit review for <b><?= $book['Title'] ?></b></h3>
                        </div>
                        <div class="form-floating my-3">
                            <textarea class="form-control" placeholder="Leave a review here" id="review" style="height: 300px" maxlength="10000" name="edit-review"><?= stripslashes($book['FullReview']) ?></textarea>
                        </div>
                        <button type="submit" name="submitfullreview" class="btn btn-primary">Edit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!---------DIALOGBOX--------->
    <div class="modal fade" id="pop-up-box-successful" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <b>The review is successfully edited!</b>
                    <a href="<?=$thisFile?>"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 3%;"></button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pop-up-box-failed" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <b class="text-danger">The review cannot be edited! Try again!</b>
                    <a href="<?=$thisFile?>"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 3%;"></button></a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script>
        const editPopUpBox = new bootstrap.Modal(document.getElementById('pop-up-box-edit'));
        const successPopUpBox = new bootstrap.Modal(document.getElementById('pop-up-box-successful'));
        const failedPopUpBox = new bootstrap.Modal(document.getElementById('pop-up-box-failed'));
    </script>
</body>
</html>
<?php 
    if(isset($_POST['editreview'])){
        echo "
            <script>
                editPopUpBox.show();
            </script>
        ";
    };

    if(isset($_POST['submitfullreview'])){
        if(editReview($_POST) > 0){
            echo "
                <script>
                    editPopUpBox.hide();
                    successPopUpBox.show();
                </script>
            ";
        } else {
            echo mysqli_error($conn);
            echo "
                <script>
                    editPopUpBox.hide();
                    failedPopUpBox.show();
                </script>
            ";
        }
    }
?>