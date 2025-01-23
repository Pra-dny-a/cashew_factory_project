document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (newPassword !== confirmPassword) {
        alert('New passwords do not match.');
        event.preventDefault();
    }
});
