<?php 
    require '../func.php';
    $searchKeyword = $_GET['search-input'];
    if($searchKeyword !== ''){
        $query = "SELECT * FROM booklist WHERE
                Title LIKE '%$searchKeyword%' OR
                Author LIKE '%$searchKeyword%' OR
                Genre LIKE '%$searchKeyword%'
    ";
    } else {
        $query = "SELECT * FROM booklist";
    }
    $books = query($query);
?>

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
                    <p class="fs-6"><?= $book['ShortReview'] ?></p>
                </td>
                <td>
                    <button type="button" class="btn btn-primary my-1 p-1 px-2 mx-sm-0 mx-3"><p class="m-0 fs-6"><a href="booklist.php?edit=true&id=<?= $book['id']; ?>&title=<?= $book['Title']; ?>&author=<?= $book['Author']; ?>&genre=<?= $book['Genre']; ?>&cover=<?= $book['BookCover']; ?>&pages=<?= $book['Pages']; ?>&date=<?= $book['DateRead']; ?>&rating=<?= $book['Rating']; ?>&comment=<?= $book['ShortReview']; ?>" class="text-decoration-none text-light"><i class="fas fa-pencil-alt"></i></a></p></button>
                    <button type="button" class="btn btn-danger my-1 p-1 px-2 mx-sm-0 mx-3"><p class="m-0 fs-6"><a href="booklist.php?id=<?= $book['id']; ?>&delete=true" class="text-decoration-none text-light"><i class="fas fa-trash"></i></a></p></button>
                </td>
            </tr>
        <?php $num++; ?>
        <?php endforeach; ?>
    </tbody>
</table>