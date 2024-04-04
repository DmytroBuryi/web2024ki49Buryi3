<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-page">
        <button type="button" class="btn btn-primary logout-btn" id="logout-btn">Log Out</button>
        <div class="main-page-block">
            <div class="main-page-info-block">
                <input id="search-input-user">
                <button type='button' class="btn btn-primary" id="search-user-btn">Пошук</button>
                <div>
                    <p><b>Email:</b> <span id="user-login"></span></p>
                    <p><b>Name:</b> <span id="user-name"></span></p>
                    <p><b>Password:</b> <span id="user-password"></span></p>
                </div>
            </div>
            <hr>
            <div class="main-page-input-block">
                <div class="edit-block">
                    <label>Email:</label>
                    <input type="email" id="email-input" placeholder="Email:">
                </div>
                <div class="edit-block">
                    <label>Name:</label>
                    <input type="text" id="user-name-input" placeholder="UserName:">
                </div>
                <div class="edit-block">
                    <label>Password:</label>
                    <input type="text" id="user-password-input" placeholder="Password:">
                </div>
                <div id="errors">
                
                </div>
                <div class="update-btn">
                    <button type="button" class="btn btn-primary" id="update-user-btn">Оновити дані</button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">

function getUserData(name = "") {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let data = this.responseText;
            if (data) {
                let parsedData = JSON.parse(data);
                if (parsedData !== null) {
                    document.getElementById("user-login").textContent = parsedData.Email;
                    document.getElementById("user-name").textContent = parsedData.UserName;
                    document.getElementById("user-password").textContent = parsedData.Password;

                    document.getElementById("email-input").value = parsedData.Email;
                    document.getElementById("user-name-input").value = parsedData.UserName;
                    document.getElementById("user-password-input").value = parsedData.Password;
                } else {
                    console.log("Parsed data is null.");
                }
            } else {
                console.log("No data received.");
            }
        }
    };
    xhr.open("GET", "mainPage.service.php?name=" + name + "&action=getUserByName", true);
    xhr.send();
}

document.addEventListener("DOMContentLoaded", function () {
    let name = "";
    getUserData();

    document.getElementById("search-user-btn").addEventListener("click", function (e) {
        e.preventDefault();
        name = document.getElementById("search-input-user").value || name;
        getUserData(name);
    });

document.getElementById("update-user-btn").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("errors").innerHTML = "";
    const email = document.getElementById("email-input").value;
    const user_name = document.getElementById("user-name-input").value;
    const password = document.getElementById("user-password-input").value;

    if (!email || !user_name || !password) {
        document.getElementById("errors").innerHTML = "<div class='error-box'><p>Fields for update user data cannot be empty!</p></div>";
        document.getElementById("errors").style.display = "block";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getUserData(user_name); // Оновлено для виклику з іменем користувача
            // Оновлення інших полів
            document.getElementById("user-login").textContent = email; // Оновлюємо Email
            document.getElementById("user-name").textContent = user_name; // Оновлюємо Name
            document.getElementById("user-password").textContent = password; // Оновлюємо Password
        }
    };
    xhr.open("POST", "mainPage.service.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("name=" + user_name + "&email=" + email + "&user_name=" + user_name + "&password=" + password + "&action=updateUserByName");
});


    document.getElementById("logout-btn").addEventListener("click", function (e) {
        e.preventDefault();

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                window.location.href = "/login.html";
            }
        };
        xhr.open("POST", "mainPage.service.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("action=logout");
    });
});


</script>

</body>
</html>
