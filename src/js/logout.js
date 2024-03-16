// logout.js
// Track user activity
document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);

let timer;


const timeoutDuration = 900000; // 15 minutes
function resetTimer() {
    clearTimeout(timer);
    timer = setTimeout(logout, timeoutDuration);
}

function logout() {
    window.location.href = '../model/logout.php';
    console.log("Button appelé");
}
