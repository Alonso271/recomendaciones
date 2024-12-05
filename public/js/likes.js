document.addEventListener('DOMContentLoaded', function () {
    const likeBtn = document.getElementById('like-btn');
    const likesCountElement = document.getElementById('likes-count');

    likeBtn.addEventListener('click', function (e) {
        e.preventDefault();

        fetch("/review/like", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                review_id: likeBtn.dataset.reviewId
            })
        })
        .then(response => response.json())
        .then(data => {
            likesCountElement.textContent = data.likes_count;
        })
        .catch(error => console.error('Error:', error));
    });
});


