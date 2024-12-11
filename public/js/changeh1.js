document.addEventListener('DOMContentLoaded', function() {
    const title = document.querySelector('h1');

    setTimeout(() => {
        title.classList.add('changed');

        setTimeout(() => {
            title.classList.remove('changed');
        }, 500);
    }, 100);
});




