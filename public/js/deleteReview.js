document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.see-more').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const reviewId = this.dataset.reviewId;
            const url = this.dataset.url;

            console.log('Review ID:', reviewId);
            console.log('URL:', url);

            document.querySelector('#confirm-delete').dataset.reviewId = reviewId;
            document.querySelector('#confirm-delete').dataset.url = url;
        });
    });

    document.querySelector('#confirm-delete').addEventListener('click', function() {
        const reviewId = this.dataset.reviewId;
        const url = this.dataset.url;

        console.log('Confirming deletion for:', reviewId);
        console.log('URL:', url);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ review_id: reviewId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Comentario eliminado exitosamente');
                $('#confirmModal').modal('hide');
                const reviewElement = document.querySelector(`#review-${reviewId}`);
                if (reviewElement) {
                    reviewElement.remove();
                }
            } else {
                alert(data.message || 'Hubo un error al eliminar el comentario.');
            }
        })
        .catch(error => {
            console.error(error);
            alert('Hubo un problema con la solicitud.');
        });
    });
});
