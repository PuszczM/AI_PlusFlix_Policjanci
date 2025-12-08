document.addEventListener('DOMContentLoaded', () => {

    const hearts = document.querySelectorAll('.heart');

    function getFavorites() {
        return JSON.parse(localStorage.getItem('favorites') || '[]');
    }

    function saveFavorites(favs) {
        localStorage.setItem('favorites', JSON.stringify(favs));
    }

    function toggleFavorite(id, heart) {
        let favs = getFavorites();

        if (favs.includes(id)) {
            favs = favs.filter(f => f !== id);
            heart.classList.remove('favorited');
            heart.classList.add('not-favorited');
        } else {
            favs.push(id);
            heart.classList.add('favorited');
            heart.classList.remove('not-favorited');
        }

        saveFavorites(favs);
    }

    hearts.forEach(heart => {
        const movieId = heart.dataset.id;
        const favs = getFavorites();

        if (favs.includes(movieId)) {
            heart.classList.add('favorited');
        } else {
            heart.classList.add('not-favorited');
        }

        heart.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            toggleFavorite(movieId, heart);
        });
    });

});
