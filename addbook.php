<?php 
    session_start();
    
    if(!isset($_SESSION['login'])){
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add book - libSHELF</title>
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
                <div class="container-fluid gap-2 col-sm-11 col-10 p-1 mx-auto">
                    <div class="buttons row">
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="index.php" class="text-decoration-none text-reset"><i class="fas fa-tachometer-alt me-3"></i>Dashboard</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="myprofile.php" class="text-decoration-none text-reset"><i class="fas fa-user me-3"></i>Profile</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="booklist.php" class="text-decoration-none text-reset"><i class="fas fa-book me-3"></i>Book List</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="myreviews.php" class="text-decoration-none text-reset"><i class="fas fa-sticky-note me-3"></i>My Reviews</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded btn disabled"><a href="#" class="text-decoration-none text-reset"><i class="fas fa-plus me-3"></i>Add Books</a></button>
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
                    <div class="col-lg-5 col-md-10 col-11 m-auto rounded shadow p-3">
                        <p class="fs-2 fw-bold my-1">Add Book</p>
                        <form action="" method="post" enctype="multipart/form-data" class="my-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="bookTitle" placeholder="Book Title" name="title" maxlength="50">
                                <label for="bookTitle">Book Title</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="bookAuthor" placeholder="Book Author" name="author" maxlength="50">
                                <label for="bookAuthor">Book Author</label>
                            </div>
                            <div class="mb-3">
                                <label for="cover"><p class="fs-6 m-0 fw-bolder">Select Book Cover:</p></label>
                                <input type="file" class="form-control" id="cover" placeholder="Book Cover" name="cover">
                            </div>
                            <div>
                                <p class="fs-6 m-0 fw-bolder">Select Genre:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Mystery" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox1">Mystery</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Romance" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox2">Romance</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Thriller" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox3">Thriller</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="Fantasy" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox4">Fantasy</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="Sci-Fi" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox5">Sci-Fi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="Young Adult" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox6">Young Adult</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="Classics" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox7">Classics</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox8" value="NonFiction" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox8">NonFiction</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox9" value="Science" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox9">Science</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox10" value="Psychology" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox10">Psychology</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox11" value="Best Book of The Year" name="genre[]">
                                    <label class="form-check-label" for="inlineCheckbox11"><b>Best Book of The Year</b></label>
                                </div>
                            </div>
                            <div class="form-floating my-3">
                                <input type="number" class="form-control" id="Pages" placeholder="Pages" name="pages">
                                <label for="Pages">Pages</label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="date" class="form-control" id="DateRead" placeholder="Date Read" name="date">
                                <label for="DateRead">Date Read</label>
                            </div>
                            <div class="rating">
                                <p class="fs-6 m-0 fw-bolder">Rating:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="1">
                                    <label class="form-check-label" for="rating-radio">1<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="1.5">
                                    <label class="form-check-label" for="rating-radio">1.5<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="2">
                                    <label class="form-check-label" for="rating-radio">2<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="2.5">
                                    <label class="form-check-label" for="rating-radio">2.5<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="3">
                                    <label class="form-check-label" for="rating-radio">3<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="3.5">
                                    <label class="form-check-label" for="rating-radio">3.5<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="4">
                                    <label class="form-check-label" for="rating-radio">4<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="4.5">
                                    <label class="form-check-label" for="rating-radio">4.5<i class="fas fa-star mx-1"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="5">
                                    <label class="form-check-label" for="rating-radio">5<i class="fas fa-star mx-1"></i></label>
                                </div>
                            </div>
                            <div class="form-floating my-3">
                                <textarea class="form-control" placeholder="Leave a comment here" id="comment" style="height: 100px" maxlength="200" name="comment"></textarea>
                                <label for="comment">Leave a comment here (max 200 characters)</label>
                            </div>
                            <div class="form-floating my-3">
                                <textarea class="form-control" placeholder="Leave a review here" id="review" style="height: 300px" maxlength="10000" name="review"></textarea>
                                <label for="review">Leave full review here</label>
                            </div>
                            <button class="btn btn-primary" type="submit" name="submit">Add Book!</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <!---------DIALOGBOX--------->
    <div class="modal fade" id="pop-up-box-successful" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <b>The book is successfully added!</b>
                    <a href="booklist.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 3%;"></button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pop-up-box-failed" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <b class="text-danger">The book cannot be added! Try again!</b>
                    <a href="addbook.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 3%;"></button></a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script>
        const successfulAdded = new bootstrap.Modal(document.getElementById('pop-up-box-successful'));
        const failedAdded = new bootstrap.Modal(document.getElementById('pop-up-box-failed'));
    </script>
</body>
</html>

<?php 
    require 'func.php';
    if(isset($_POST['submit'])){
        if(add($_POST) > 0){
            echo '
                <script>
                    successfulAdded.show();
                </script>
            ';
        } else {
            echo mysqli_error($conn);
            '
                <script>
                    failedAdded.show();
                </script>
            ';
        }
    }
?>