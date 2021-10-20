const searchInput = document.getElementById("search-books");
const tableContainer = document.getElementById("table-container");

searchInput.addEventListener("keypress", (e) => {
    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = () => {
        if(ajax.readyState == 4 && ajax.status == 200){
            tableContainer.innerHTML = ajax.responseText;
        }
    }

    ajax.open("GET", 'ajax/booklist-table.php?search-input=' + searchInput.value, true);
    ajax.send();
})