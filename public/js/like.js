document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="like-btn"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const reviewId = this.dataset.reviewId;
            const url = this.dataset.url;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ review_id: reviewId, action: 'like' })
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error || 'Error desconocido');
                    });
                }
            })
            .then(data => {
                document.querySelector(`#likes-count-${reviewId}`).innerText = data.likes_count;
                document.querySelector(`#dislikes-count-${reviewId}`).innerText = data.dislikes_count;
            })
            .catch(error => {
                alert(error.message);
            });
        });
    });

    document.querySelectorAll('[id^="dislike-btn"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const reviewId = this.dataset.reviewId;
            const url = this.dataset.url;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ review_id: reviewId, action: 'dislike' })
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error);
                    });
                }
            })
            .then(data => {
                document.querySelector(`#likes-count-${reviewId}`).innerText = data.likes_count;
                document.querySelector(`#dislikes-count-${reviewId}`).innerText = data.dislikes_count;
            })
            .catch(error => {
                alert(error.message);
            });
        });
    });
});
