<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Safety Awareness - Crime Analysis</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f6f8;
    color: #222;
}

/* HEADER */

header {
    background-color: #17202a;
    color: white;
    padding: 20px 50px;

    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 {
    font-size: 24px;
}

nav a {
    color: white;
    text-decoration: none;
    margin-left: 25px;
}

nav a:hover {
    color: #5dade2;
}

/* CONTAINER */

.container {
    width: 90%;
    max-width: 1000px;
    margin: 40px auto;
}

.title {
    text-align: center;
    font-size: 32px;
    margin-bottom: 10px;
}

.subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 35px;
}

/* CATEGORY SECTION */

.category-section {
    background-color: white;

    padding: 30px;

    border-radius: 10px;

    box-shadow: 0 3px 10px rgba(0,0,0,0.1);

    margin-bottom: 30px;
}

.category-section h2 {
    margin-bottom: 15px;
    color: #273746;
}

.category-section p {
    color: #666;
    margin-bottom: 20px;
}

select {
    width: 100%;

    padding: 13px;

    font-size: 16px;

    border: 1px solid #aaa;

    border-radius: 5px;

    background-color: white;

    cursor: pointer;
}

/* RESULT CARD */

.safety-card {
    display: none;

    background-color: white;

    padding: 30px;

    border-radius: 10px;

    box-shadow: 0 3px 10px rgba(0,0,0,0.1);

    margin-bottom: 30px;
}

.safety-card h2 {
    color: #273746;
    margin-bottom: 18px;
}

.safety-card ul {
    padding-left: 22px;
}

.safety-card li {
    margin-bottom: 12px;
    line-height: 1.6;
}

/* EMERGENCY */

.emergency {
    margin-top: 40px;

    background-color: #17202a;

    color: white;

    padding: 30px;

    border-radius: 10px;

    text-align: center;
}

.emergency h2 {
    margin-bottom: 15px;
}

.emergency p {
    margin-bottom: 20px;
    color: #ddd;
}

.number {
    display: inline-block;

    background-color: white;

    color: #17202a;

    padding: 15px 30px;

    border-radius: 5px;

    font-weight: bold;

    font-size: 18px;
}

/* FOOTER */

footer {
    background-color: #17202a;

    color: white;

    text-align: center;

    padding: 20px;

    margin-top: 50px;
}

/* MOBILE */

@media screen and (max-width: 768px) {

    header {
        padding: 20px;
        flex-direction: column;
        gap: 15px;
    }

    nav {
        text-align: center;
    }

    nav a {
        display: inline-block;
        margin: 5px 8px;
    }

    .container {
        width: 94%;
    }

    .title {
        font-size: 26px;
    }

}

</style>

</head>


<body>


<header>

<h1>Crime Analysis</h1>

<nav>

<a href="index.php">Dashboard</a>

<a href="crime_data.php">Crime Data</a>

<a href="analysis.php">Analysis</a>

<a href="safety.php">Safety Tips</a>

</nav>

</header>


<div class="container">


<h1 class="title">
Community Safety Awareness
</h1>

<p class="subtitle">
Select a category to view relevant safety information
</p>


<!-- SAFETY CATEGORY -->

<div class="category-section">

<h2>Select Safety Category</h2>

<p>
Choose the type of safety information you want to view.
</p>

<select id="category" onchange="showSafety()">

<option value="">
-- Select Category --
</option>

<option value="personal">
Personal Safety
</option>

<option value="night">
Night Safety
</option>

<option value="cyber">
Cyber Crime Safety
</option>

<option value="vehicle">
Vehicle Safety
</option>

<option value="home">
Home Safety
</option>

<option value="social">
Social Media Safety
</option>

</select>

</div>


<!-- PERSONAL SAFETY -->

<div class="safety-card" id="personal">

<h2>👤 Personal Safety</h2>

<ul>

<li>Stay aware of your surroundings in public places.</li>

<li>Avoid displaying expensive valuables unnecessarily.</li>

<li>Keep important documents and personal information secure.</li>

<li>Inform someone you trust when travelling alone.</li>

<li>Avoid isolated areas whenever possible.</li>

</ul>

</div>


<!-- NIGHT SAFETY -->

<div class="safety-card" id="night">

<h2>🌙 Night Safety</h2>

<ul>

<li>Prefer well-lit and populated routes.</li>

<li>Avoid walking alone in unfamiliar isolated areas.</li>

<li>Keep your phone accessible in case you need help.</li>

<li>Use trusted transportation services.</li>

<li>Share your travel plans with someone you trust.</li>

</ul>

</div>


<!-- CYBER SAFETY -->

<div class="safety-card" id="cyber">

<h2>📱 Cyber Crime Safety</h2>

<ul>

<li>Never share OTPs, passwords or PINs with anyone.</li>

<li>Use strong and unique passwords.</li>

<li>Avoid clicking suspicious links or attachments.</li>

<li>Verify websites before entering financial information.</li>

<li>Be careful with unknown calls, messages and emails.</li>

</ul>

</div>


<!-- VEHICLE SAFETY -->

<div class="safety-card" id="vehicle">

<h2>🚗 Vehicle Safety</h2>

<ul>

<li>Always lock your vehicle properly.</li>

<li>Park in secure and well-lit areas.</li>

<li>Never leave valuable items visible inside vehicles.</li>

<li>Use appropriate anti-theft measures.</li>

<li>Keep vehicle documents secure.</li>

</ul>

</div>


<!-- HOME SAFETY -->

<div class="safety-card" id="home">

<h2>🏠 Home Safety</h2>

<ul>

<li>Lock doors and windows when leaving home.</li>

<li>Do not share unnecessary personal information with strangers.</li>

<li>Check visitors before opening the door.</li>

<li>Keep emergency contacts easily accessible.</li>

<li>Report suspicious activity to the appropriate authorities.</li>

</ul>

</div>


<!-- SOCIAL MEDIA SAFETY -->

<div class="safety-card" id="social">

<h2>🌐 Social Media Safety</h2>

<ul>

<li>Avoid publicly sharing your address or daily routine.</li>

<li>Use privacy settings on social media accounts.</li>

<li>Do not accept requests from unknown people blindly.</li>

<li>Think carefully before sharing photographs or personal information.</li>

<li>Report suspicious or abusive accounts.</li>

</ul>

</div>


<!-- EMERGENCY -->

<div class="emergency">

<h2>🚨 Emergency Awareness</h2>

<p>
In an emergency, move to a safe location and contact the appropriate emergency service or local authority.
</p>

<div class="number">
Emergency: 112
</div>

</div>


</div>


<footer>

<p>
© 2026 Crime Analysis for Community Safety Awareness
</p>

</footer>


<script>

function showSafety() {

    var selectedCategory =
        document.getElementById("category").value;

    var cards =
        document.getElementsByClassName("safety-card");

    /* Hide all cards */

    for (var i = 0; i < cards.length; i++) {

        cards[i].style.display = "none";

    }

    /* Show only selected category */

    if (selectedCategory != "") {

        document.getElementById(
            selectedCategory
        ).style.display = "block";

    }

}

</script>


</body>

</html>