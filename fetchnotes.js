document.addEventListener('DOMContentLoaded', function() {
    const notesModal = document.getElementById('notesModal');
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form); // Get form data

        fetch('submitnotes.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Expect a JSON response
        .then(data => {
            
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    form.reset();
                    
                    fetchNotes(); // Fetch notes after submission
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => console.error('Error adding note:', error));
    });

    function fetchNotes() {
        fetch('fetchnotes.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('notesContainer').innerHTML = data;

                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-note').forEach(button => {
                    button.addEventListener('click', function() {
                        const noteId = this.getAttribute('data-id');
                        deleteNote(noteId);
                    });
                });
            })
            .catch(error => console.error('Error fetching notes:', error));
    }

    
    function deleteNote(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('deletenote.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + id
                })
                .then(response => response.text())
                .then(data => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Your note has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        fetchNotes(); // Refresh the notes list after deletion
                    });
                })
                .catch(error => console.error('Error deleting note:', error));
            }
        });
    }

    // Fetch notes when modal is shown
    notesModal.addEventListener('show.bs.modal', fetchNotes);
});

