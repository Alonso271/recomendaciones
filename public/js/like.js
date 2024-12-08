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
                } else if (response.status === 401) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message);
                    });
                } else {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Ocurrió un error.');
                    });
                }
            })
            .then(data => {
                document.querySelector(`#likes-count-${reviewId}`).innerText = data.likes_count;
                document.querySelector(`#dislikes-count-${reviewId}`).innerText = data.dislikes_count;
            })
            .catch(error => {
                const messageContainer = document.getElementById('message-container');
                messageContainer.classList.remove('d-none', 'alert-success');
                messageContainer.classList.add('alert-danger');
                messageContainer.innerText = error.message;

                messageContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
                } else if (response.status === 401) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message);
                    });
                } else {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Ocurrió un error.');
                    });
                }
            })
            .then(data => {
                document.querySelector(`#likes-count-${reviewId}`).innerText = data.likes_count;
                document.querySelector(`#dislikes-count-${reviewId}`).innerText = data.dislikes_count;
            })
            .catch(error => {
                const messageContainer = document.getElementById('message-container');
                messageContainer.classList.remove('d-none', 'alert-success');
                messageContainer.classList.add('alert-danger');
                messageContainer.innerText = error.message;

                messageContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    });
});
