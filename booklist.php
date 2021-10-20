<?php 
    require 'func.php';
    session_start();
    $books = query('SELECT * FROM booklist ORDER BY date(DateRead) DESC');
    $thisFile = 'booklist.php';
    $dateRead = query("SELECT DateRead FROM booklist");
    $selectedYear = '';

    if(count($dateRead) !== 0){
        foreach($dateRead as $date){
            $years[] = explode('-', $date["DateRead"])[0]; 
        }
        $years = array_unique($years);
        rsort($years);
    }
    
    if(isset($_POST['year-filter-submit'])){
        if($_POST['year-filter'] != ""){
            $books = selectYear($_POST['year-filter']);
            $selectedYear = $_POST['year-filter'];
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Books - libSHELF</title>
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
                        <button class="aside-button text-light p-2 my-2 text-start rounded btn disabled"><a href="#" class="text-decoration-none text-reset"><i class="fas fa-book me-3"></i>Book List</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="myreviews.php" class="text-decoration-none text-reset"><i class="fas fa-sticky-note me-3"></i>My Reviews</a></button>
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
                            <p class="col-md-0 profile-name fs-6"><?= isset($_SESSION['login']) ? 'Ara Gamaliel' : 'Guest' ?></p>
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
                    <p class="fs-2 fw-bold">Books You Have Read So Far...</p>
                    <div class="row">
                        <div class="col-md-3 col-10">
                            <form action="" method="post" id="year-filter">
                                <div class="row">
                                    <label for="selectYear" class="fw-bold">Filter year: </label>
                                    <div class="col-10 m-0">
                                        <select class="form-select ms-0" name="year-filter" aria-label="Default select example" id="selectYear">
                                            <option value="">All Years</option>
                                            <?php foreach($years as $year):?>
                                                <option value="<?=$year?>" <?= ($year === $selectedYear ? 'selected="true"' : ''); ?>><?=$year?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-2 m-0 p-0">
                                        <button type="submit" name="year-filter-submit" class="btn btn-primary my-1 p-1 px-2 mx-sm-0 mx-3"><i class="fas fa-filter"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <form action="" method="post">
                                <label for="search-books" class="fw-bold">Search books: </label>  
                                <div class="input-group mb-3 mx-1">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control fs-6" id="search-books" name="search-keyword" placeholder="Insert title, author, genre here" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="container-fluid table-responsive p-0" id="table-container">
                        <table class="table table-hover w-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center fs-6" style="width:5%">No</th>
                                    <th scope="col" class="text-center fs-6" style="width:10%">Title</th>
                                    <th scope="col" class="text-center fs-6" style="width:15%">Book Cover</th>
                                    <th scope="col" class="text-center fs-6" style="width:10%">Author</th>
                                    <th scope="col" class="text-center fs-6" style="width:10%">Genre</th>
                                    <th scope="col" class="text-center fs-6" style="width:10%">Pages</th>
                                    <th scope="col" class="text-center fs-6" style="width:10%">Date Read</th>
                                    <th scope="col" class="text-center fs-6" style="width:5%">Rating</th>
                                    <th scope="col" class="text-center fs-6" style="width:15%">Short Review</th>
                                    <th scope="col" class="text-center fs-6" style="width:10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                <?php foreach($books as $book): ?>
                                    <tr>
                                        <th scope="row" class="text-center fs-6"><?= $num; ?></th>
                                        <td class="text-center fs-6"><?= $book['Title']; ?></td>
                                        <td><img src="./src/img/<?= $book['BookCover'] ?>" alt="" class="book-cover mx-auto w-50" style="display:flex;"></td>
                                        <td class="text-center fs-6"><?= $book['Author'] ?></td>
                                        <td class="text-center fs-6"><?= $book['Genre'] ?></td>
                                        <td class="text-center fs-6"><?= $book['Pages'] ?></td>
                                        <td class="text-center fs-6"><?= $book['DateRead'] ?></td>
                                        <td class="text-center fs-6"><?= $book['Rating'] ?><i class="fas fa-star mx-1"></i></td>
                                        <td class="short-review text-center fs-6">
                                            <p class="fs-6"><?= stripslashes($book['ShortReview']) ?></p>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary my-1 p-1 px-2 mx-sm-0 mx-3 <?=isset($_SESSION['login']) ? "" : "disabled"?>"><p class="m-0 fs-6"><a href="booklist.php?edit=true&id=<?= $book['id']; ?>&title=<?= $book['Title']; ?>&author=<?= $book['Author']; ?>&genre=<?= $book['Genre']; ?>&cover=<?= $book['BookCover']; ?>&pages=<?= $book['Pages']; ?>&date=<?= $book['DateRead']; ?>&rating=<?= $book['Rating']; ?>&comment=<?= $book['ShortReview']; ?>" class="text-decoration-none text-light"><i class="fas fa-pencil-alt"></i></a></p></button>
                                            <button type="button" class="btn btn-danger my-1 p-1 px-2 mx-sm-0 mx-3 <?=isset($_SESSION['login']) ? "" : "disabled"?>"><p class="m-0 fs-6"><a href="booklist.php?id=<?= $book['id']; ?>&delete=true" class="text-decoration-none text-light"><i class="fas fa-trash"></i></a></p></button>
                                        </td>
                                    </tr>
                                <?php $num++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <!---------DIALOGBOX--------->
    <div class="modal fade" id="success-pop-up-box" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <b>Success!</b>
                    <a href="<?=$thisFile?>"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 3%;"></button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="failed-pop-up-box" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <b>Failed. Try again!</b>
                    <a href="<?=$thisFile?>"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 3%;"></button></a>
                </div>
            </div>
        </div>
    </div>
    
    <!---------EDIT DIALOGBOX--------->
    <div class="modal fade" id="edit-popupbox" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Book</h5>
                <a href="<?=$thisFile?>"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" class="my-3">
                    <input type="hidden" name="id" value="<?=$_GET['id']?>">
                    <input type="hidden" name="currentImage" value="<?=$_GET['cover']?>">
                    <?php $genres = explode(', ', $_GET['genre']); ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="bookTitle" placeholder="Book Title" name="title" maxlength="50" value="<?=$_GET['title']?>">
                        <label for="bookTitle">Book Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="bookAuthor" placeholder="Book Author" name="author" maxlength="50" value="<?=$_GET['author']?>">
                        <label for="bookAuthor">Book Author</label>
                    </div>
                    <div class="mb-3">
                        <label for="cover"><p class="fs-6 m-0 fw-bolder">Select Book Cover:</p></label>
                        <input type="file" class="form-control" id="cover" placeholder="Book Cover" name="cover">
                    </div>
                    <div>
                        <p class="fs-6 m-0 fw-bolder">Select Genre:</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Mystery" name="genre[]" <?php echo (in_array("Mystery", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox1">Mystery</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Romance" name="genre[]" <?php echo (in_array("Romance", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox2">Romance</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Thriller" name="genre[]" <?php echo (in_array("Thriller", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox3">Thriller</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="Young Adult" name="genre[]" <?php echo (in_array("Young Adult", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox4">Young Adult</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="Classics" name="genre[]" <?php echo (in_array("Classics", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox5">Classics</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="Sci-Fi" name="genre[]" <?php echo (in_array("Sci-Fi", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox6">Sci-Fi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="Fantasy" name="genre[]" <?php echo (in_array("Fantasy", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox7">Fantasy</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox8" value="Psychology" name="genre[]" <?php echo (in_array("Psychology", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox8">Psychology</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox9" value="Science" name="genre[]" <?php echo (in_array("Science", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox9">Science</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox10" value="NonFiction" name="genre[]" <?php echo (in_array("NonFiction", $genres)) ? "checked" : "" ?>>
                            <label class="form-check-label" for="inlineCheckbox10">NonFiction</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox11" value="Best Book of The Year" name="genre[]">
                            <label class="form-check-label" for="inlineCheckbox11"><b>Best Book of The Year</b></label>
                        </div>
                    </div>
                    <div class="form-floating my-3">
                        <input type="number" class="form-control" id="Pages" placeholder="Pages" name="pages" value="<?=$_GET['pages']?>">
                        <label for="Pages">Pages</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="date" class="form-control" id="DateRead" placeholder="Date Read" name="date" value="<?=$_GET['date']?>">
                        <label for="DateRead">Date Read</label>
                    </div>
                    <div class="rating">
                        <p class="fs-6 m-0 fw-bolder">Select Genre:</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="1" <?php echo ($_GET['rating'] == 1) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">1<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="1.5" <?php echo ($_GET['rating'] == 1.5) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">1.5<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="2" <?php echo ($_GET['rating'] == 2) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">2<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="2.5" <?php echo ($_GET['rating'] == 2.5) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">2.5<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="3" <?php echo ($_GET['rating'] == 3) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">3<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="3.5" <?php echo ($_GET['rating'] == 3.5) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">3.5<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="4" <?php echo ($_GET['rating'] == 4) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">4<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="4.5" <?php echo ($_GET['rating'] == 4.5) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">4.5<i class="fas fa-star mx-1"></i></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="flexRadioDefault2" value="5" <?php echo ($_GET['rating'] == 5) ? "checked": ""?>>
                            <label class="form-check-label" for="rating-radio">5<i class="fas fa-star mx-1"></i></label>
                        </div>
                    </div>
                    <div class="form-floating my-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="comment" style="height: 100px" maxlength="200" name="comment"><?=$_GET['comment']?></textarea>
                        <label for="comment">Leave a comment here (max 200 characters)</label>
                    </div>
                    <button class="btn btn-primary" type="submit" name="editsubmit">Edit Book!</button>
                </form>
            </div>
            <div class="modal-footer">
                <a href="<?=$thisFile?>"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></a>
            </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/search.js"></script>
    <script>
        const editPopUpBox = new bootstrap.Modal(document.getElementById('edit-popupbox'));
        const successPopUpBox = new bootstrap.Modal(document.getElementById('success-pop-up-box'));
        const failPopUpBox = new bootstrap.Modal(document.getElementById('failed-pop-up-box'));
    </script>
</body>
</html>

<?php
    if(isset($_GET['id']) && isset($_GET['delete'])){
        $id = $_GET['id'];

        if(delete($id) > 0){
            echo '
            <script>
                successPopUpBox.show();
            </script>
            ';
        } else {
            echo '
            <script>
                failPopUpBox.show();
            </script>
            ';
        }
    }

    if(isset($_GET['id']) && isset($_GET['edit'])){
        if(isset($_SESSION['login'])){
            if(isset($_POST['editsubmit'])){
                if(edit($_POST) > 0){
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
                        failPopUpBox.show();
                    </script>    
                ";
                }
            } else {
                echo '
                <script>
                    editPopUpBox.show();
                </script>    
            ';
            }
        }
    }
?>