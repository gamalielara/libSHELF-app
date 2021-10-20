<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'mylibrary');

    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];

        // to fetch data from $result object using mysqli_fetch_assoc();
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }

        return $rows;
    }

    function delete($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM booklist WHERE id = $id");
        return mysqli_affected_rows($conn);
    }

    function add($data){
        global $conn;
        $title = htmlspecialchars($data['title']); /* string */
        $author = htmlspecialchars($data['author']); /* string */
        $genres = $data['genre']; /* array */
        $pages = $data['pages']; /* integer */
        $date = date("Y-m-d", strtotime($data['date'])); /* date */
        $rating = $data['rating']; /* float */
        $comment = htmlspecialchars(addslashes($data['comment'])); /* string/text */
        $fullReview = $data['review']; /* string/text */
        $fullReview = addslashes($fullReview);
        $cover = uploadPicture();

        $genre = '';

        foreach($genres as $g):
            if($g === $genres[count($genres)-1]):
                $genre .= $g;
            else: $genre .= $g . ', ';
            endif;
        endforeach;
            

        $query = "INSERT INTO booklist 
                    VALUES
                    (NULL, '$title', '$cover', '$author', '$genre', '$pages', '$date', '$rating', '$comment', '$fullReview')
                ";

        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function uploadPicture(){
        $picName = $_FILES['cover']['name'];
        $picSize = $_FILES['cover']['size'];
        $error = $_FILES['cover']['error'];
        $tmpName = $_FILES['cover']['tmp_name'];

        // screening
        if($error === 4){
            return "nocover.png";
        }

        $validPictureExtension = ['jpg', 'jpeg', 'png'];
        $uploadedPictureExtension = explode('.', $picName);
        $uploadedPictureExtension = end($uploadedPictureExtension);

        if(!in_array($uploadedPictureExtension, $validPictureExtension)){
            echo "
                <script>
                    alert('Choose an image file (jpeg/png/jpg)!);
                </script>
            ";
            return false;
        }

        if($picSize > 2000000){
            echo "
                <script>
                    alert('The image chosen is too big!);
                </script>
            ";
            return false;
        }

        $newImageName = uniqid() . '.' . $uploadedPictureExtension;
        move_uploaded_file($tmpName, 'src/img/' . $newImageName);
        return $newImageName;
    }

    function edit($data){
        global $conn;
        $id = $data['id'];
        $title = htmlspecialchars($data['title']); /* string */
        $currentCover = htmlspecialchars($data['currentImage']);
        $author = htmlspecialchars($data['author']); /* string */
        $genres = $data['genre']; /* array */
        $pages = $data['pages']; /* integer */
        $date = date("Y-m-d", strtotime($data['date'])); /* date */
        $rating = $data['rating']; /* float */
        $comment = htmlspecialchars(addslashes($data['comment'])); /* string/text */
        $fullReview = $data['review']; /* string/text */

        $genre = '';

        foreach($genres as $g):
            if($g === $genres[count($genres)-1]):
                $genre .= $g;
            else: $genre .= $g . ', ';
            endif;
        endforeach;

        if($_FILES['cover']['error'] === 4){
            $cover = $currentCover;
        } else {
            $cover = uploadPicture();
        }

        $query = "UPDATE booklist SET
                   Title = '$title',
                   BookCover = '$cover',
                   Author = '$author',
                   Genre = '$genre',
                   Pages = '$pages',
                   DateRead = '$date',
                   Rating = '$rating',
                   ShortReview = '$comment',
                   fullReview = '$fullReview'

                WHERE id = '$id'
        
        ";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function selectYear($year){
        if($year !== ''){  
            $query = "SELECT * FROM booklist WHERE DateRead LIKE '%$year%'";
        } else {
            $query = "SELECT * FROM booklist";
        }
        
        return query($query);
    }

    function editReview($data){
        global $conn;
        
        $id = $data['id'];
        $fullReview = addslashes($data['edit-review']);
        $query = "UPDATE booklist SET FullReview = '$fullReview' WHERE id='$id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function findLongestAndShortestBook($books){
        $pagesCount = 0;
        $i = 0;
        $minPages = 0;
        $maxPages = 0;
        foreach($books as $book){
            $years[]  = explode('-', $book['DateRead'])[0];
            $genre = explode(', ', $book['Genre']);
            $pagesCount += $book['Pages'];
            $i += 1;
    
            foreach($genre as $g){
                $genres[] = $g;
            }
    
            if($minPages === 0){
                $minPages = $book['Pages'];
            } else {
                if($book["Pages"] < $minPages){
                    $minPages = $book['Pages'];
                }
            }
            if($maxPages === 0){
                $maxPages = $book['Pages'];
            } else {
                if($book["Pages"] > $maxPages){
                    $maxPages = $book['Pages'];
                }
            }
        }

        $longestBookTitle = query("SELECT Title FROM booklist WHERE Pages = '$maxPages'")[0]['Title'];
        $shortestBookTitle = query("SELECT Title FROM booklist WHERE Pages = '$minPages'")[0]['Title'];

        $result['booksCount'] = $i;
        $result['pagesCount'] = $pagesCount;
        $result['genres'] = $genres;
        $result['shortestBookTitle'] = $shortestBookTitle;
        $result['shortestBookPages'] = $minPages;
        $result['longestBookTitle'] = $longestBookTitle;
        $result['longestBookPages'] = $maxPages;
        return $result;
    }

    function averageRatingCounter($theQuery){
        $rating = 0;

        foreach($theQuery as $book){
            $rating += $book['Rating'];
        }

        $result = $rating / count($theQuery);
        return substr($result, 0, 4);
    }
?>