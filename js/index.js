document.getElementById("searchButton").addEventListener("click", function () {
    let query = document.getElementById("searchInput").value;
    if (query.trim() !== "") {
        fetchBooks(query);
    }
});

document.getElementById("searchInput").addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        let query = document.getElementById("searchInput").value;
        if (query.trim() !== "") {
            fetchBooks(query);
        }
    }
});

function fetchBooks(query) {
    let apiKey = "AIzaSyCvEqqh3MdIdGcArrMhzjMv-lN9oLP7I98";
    let url = `https://www.googleapis.com/books/v1/volumes?q=${query}&langRestrict=fr&key=${apiKey}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            displayBooks(data.items);
        })
        .catch(error => console.error("Erreur lors de la récupération des livres :", error));
}

function displayBooks(books) {
    let bookResults = document.getElementById("bookResults");
    bookResults.innerHTML = "";
    
    if (!books || books.length === 0) {
        bookResults.innerHTML = "<p>Aucun livre trouvé.</p>";
        return;
    }

    books.forEach(book => {
        let bookInfo = book.volumeInfo;
        let title = bookInfo.title || "Titre inconnu";
        let authors = bookInfo.authors ? bookInfo.authors.join(", ") : "Auteur inconnu";
        let thumbnail = bookInfo.imageLinks ? bookInfo.imageLinks.thumbnail : "https://via.placeholder.com/150";

        let bookCard = `
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="${thumbnail}" class="card-img-top" alt="${title}">
                    <div class="card-body">
                        <h5 class="card-title">${title}</h5>
                        <p class="card-text">${authors}</p>
                        <button class="btn btn-primary">Ajouter à ma bibliothèque</button>
                    </div>
                </div>
            </div>
        `;
        bookResults.innerHTML += bookCard;
    });
}
