function fetchUserCounts() {
    fetch('/api/getUserCounts.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('transporterCount').innerText = data.transporterCount;
            document.getElementById('cargoOwnerCount').innerText = data.cargoOwnerCount;
        })
        .catch(error => console.error('Error fetching user counts:', error));
}

// Call this function when the admin dashboard is loaded
window.onload = fetchUserCounts;
