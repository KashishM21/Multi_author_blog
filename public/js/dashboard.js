const postActions = {
    approve(postId, btn) {
        if (confirm('Are you sure you want to approve this post?')) {
            this.updateStatus(postId, 'published', btn);
        }
    },

    reject(postId, btn) {
        if (confirm('Are you sure you want to reject this post?')) {
            this.updateStatus(postId, 'rejected', btn);
        }
    },

    updateStatus(postId, status, btn) {
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Processing...';

        fetch(`/admin/posts/${postId}/status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success || response.ok) {
                    // Refresh page or update UI
                    location.reload();
                } else {
                    alert('Something went wrong. Please try again.');
                    btn.disabled = false;
                    btn.innerText = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Even if it fails, sometimes it worked on server if it was a redirect
                // Let's just reload to be sure
                location.reload();
            });
    },

    delete(formId) {
        if (confirm('Are you sure you want to delete this post?')) {
            document.getElementById(formId).submit();
        }
    }
};
