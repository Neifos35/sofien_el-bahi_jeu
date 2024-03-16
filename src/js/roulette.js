function spin() {
    var number = Math.floor(Math.random() * 37); // Generate a random number between 0 and 36
    var color = getColor(number);
    document.getElementById("number").innerText = number;
    document.getElementById("color").innerText = color;
}

function getColor(number) {
    if (number == 0) {
        return "Green";
    } else if (number % 2 == 0) {
        return "Red";
    } else {
        return "Black";
    }
}

function placeBet() {
    var betAmount = parseInt(document.getElementById("betAmount").value);
    var betNumber = parseInt(document.getElementById("betNumber").value);
    var betColor = document.getElementById("betColor").value;
    var winningNumber = Math.floor(Math.random() * 37);
    var winningColor = getColor(winningNumber);

    if (betNumber === winningNumber && betColor === winningColor) {
        alert("You won! Congratulations!");
    } else {
        alert("Sorry, you lost. Better luck next time!");
    }
}
