<?php
    session_start();
    require 'func.php';
    $thisYear = date("Y");

    // All Books
    $allBooks = query('SELECT * FROM booklist ORDER BY date(DateRead) DESC');
    $genresAllYears = count($allBooks) !== 0 ? findLongestAndShortestBook($allBooks)['genres'] : [];
    $totalBooksAllYears = count($allBooks) !== 0 ? findLongestAndShortestBook($allBooks)['booksCount'] : [];
    $totalPagesAllYears = count($allBooks) !== 0 ? findLongestAndShortestBook($allBooks)['pagesCount'] : [];
    $shortestBookTitleAllYears = count($allBooks) !== 0 ? findLongestAndShortestBook($allBooks)['shortestBookTitle'] : [];
    $longestBookTitleAllYears = count($allBooks) !== 0 ? findLongestAndShortestBook($allBooks)['longestBookTitle'] : [];
    $maxPagesAllYears = count($allBooks) !== 0 ? findLongestAndShortestBook($allBooks)['shortestBookPages'] : [];
    $minPagesAllYears = count($allBooks) !== 0 ? findLongestAndShortestBook($allBooks)['longestBookPages'] : [];

    // this Year Books
    $thisYearBooks = query("SELECT * FROM booklist WHERE DateRead like '%$thisYear%'");
    $genresThisYears = count($thisYearBooks) !== 0 ? findLongestAndShortestBook($thisYearBooks)['genres'] : [];
    $totalBooksThisYear = count($thisYearBooks) !== 0 ? findLongestAndShortestBook($thisYearBooks)['booksCount'] : [];
    $totalPagesThisYear = count($thisYearBooks) !== 0 ? findLongestAndShortestBook($thisYearBooks)['pagesCount'] : [];
    $shortestBookTitleThisYear = count($thisYearBooks) !== 0 ? findLongestAndShortestBook($thisYearBooks)['shortestBookTitle'] : [];
    $longestBookTitleThisYear = count($thisYearBooks) !== 0 ? findLongestAndShortestBook($thisYearBooks)['longestBookTitle'] : [];
    $maxPagesThisYear = count($thisYearBooks) !== 0 ? findLongestAndShortestBook($thisYearBooks)['longestBookPages'] : [];
    $minPagesThisYear = count($thisYearBooks) !== 0 ? findLongestAndShortestBook($thisYearBooks)['shortestBookPages'] : [];

    $_SESSION['Total Books'] = $totalBooksThisYear;
    $_SESSION['Total Pages'] = $totalPagesThisYear;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>libSHELF</title>
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
                    <button class="aside-button text-light p-2 my-2 text-start rounded btn disabled"><a href="#" class="text-decoration-none text-reset"><i class="fas fa-tachometer-alt me-3"></i>Dashboard</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="myprofile.php" class="text-decoration-none text-reset"><i class="fas fa-user me-3"></i>Profile</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="booklist.php" class="text-decoration-none text-reset"><i class="fas fa-book me-3"></i>Book List</a></button>
                        <button class="aside-button text-light p-2 my-2 text-start rounded"><a href="myreviews.php" class="text-decoration-none text-reset"><i class="fas fa-sticky-note me-3"></i>Reviews</a></button>
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
                <div class="main-content container col-md-10 mx-auto p-3">
                    <div class="row gy-2 mx-1 mx-sm-2">
                        <p class="fs-2 fw-bold"><?= isset($_SESSION['login']) ? "Hello, Ara Gamaliel!" : "Hello Guest!" ?></p>
                            <?php if(count($allBooks) !== 0): ?>
                                <div class="col-md-5 col-12 mx-2 bg-light text-center p-2 mb-2 rounded text-wrap shadow">
                                    <p class="fs-6 fw-bold"><?= $thisYear ?> Overview</p>
                                    <p class="txt">You have read <?= $totalBooksThisYear ?>/<?= 50 ?> books this year!</p>
                                    <div class="progress my-2">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?= ($totalBooksThisYear/50)*100 ?>"
                                            aria-valuemin="0" aria-valuemax="100" style="width:<?=($totalBooksThisYear/50)*100?>%">
                                        <span class="percentage-books"><?= ($totalBooksThisYear/50)*100 ?>%</span>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="txt text-start">Total pages you have read: <b><?= $totalPagesThisYear ?> pages</b>.</p>
                                    <p class="txt text-start">The longest book you have read: <b><?= $longestBookTitleThisYear ?></b> with <b><?= $maxPagesThisYear ?> pages</b>.</p>
                                    <p class="txt text-start">The shortest book you have read: <b><?= $shortestBookTitleThisYear ?></b> with <b><?= $minPagesThisYear ?> pages</b>.</p>
                                </div>
                                <div class="col-md-5 col-12 mx-2 bg-light text-center p-2 mb-2 rounded text-wrap shadow">
                                    <p class="fs-6 fw-bold">All Years Overview</p>
                                    <p class="txt text-start">You have read <b><?= $totalBooksAllYears ?></b> books!</p>
                                    <p class="txt text-start">Total pages you have read: <b><?= $totalPagesAllYears ?> pages</b>.</p>
                                    <p class="txt text-start">The longest book you have read: <b><?= $longestBookTitleAllYears ?></b> with <b><?= $maxPagesAllYears ?> pages</b>.</p>
                                    <p class="txt text-start">The shortest book you have read: <b><?= $shortestBookTitleAllYears ?></b> with <b><?= $minPagesAllYears ?> pages</b>.</p>
                                </div>
                            <?php else: ?>
                                <p>Sorry, You haven't added new books yet. Add some and see the overview!</p>
                            <?php endif; ?>
                    </div>
                    <?php if(count($allBooks) !== 0): ?>
                        <div class="row gy-2 mx-1 mx-sm-2 mt-2">
                            <div class="col-md-5 col-12 mx-2 my-2 bg-light text-center p-2 rounded shadow">
                                <p class="fs-5 fw-bold"><?= $thisYear ?> Analysis</p>
                                <canvas id="bookChart" style="width: 60%;"></canvas>
                            </div>
                            <div class="col-md-5 col-12 mx-2 my-2 bg-light text-center p-2 rounded shadow">
                                <p class="fs-5 fw-bold">All Years Analysis</p>
                                <canvas id="bookChartAllYears" style="width: 60%;"></canvas>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script>
        <?php foreach($genresThisYears as $genre):?>
            genresArrayThisYear.push("<?=$genre?>");
        <?php endforeach; ?>

        <?php foreach($genresAllYears as $genre):?>
            genresArrayAllYears.push("<?=$genre?>");
        <?php endforeach; ?>
    </script>
    <script type="text/javascript" src="js/chart.js"></script>
</body>
</html>