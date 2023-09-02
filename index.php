<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoleV2</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css" />
    <link rel="stylesheet" type="text/css" href="./styles/title-screen.css" />
    <link rel="stylesheet" type="text/css" href="./styles/discover.css" />
</head>

<body>

    <div id="title-div">
        <div>
            <h1 id="title">Hole</h1>
            <p id="title-about">Crypto portfolio</p>
        </div>
        <img id="title-logo" src="./images/logo/holeiconwhite.png" alt="Hole logo">
    </div>

    <div id="navigation">
        <a href="./index.php">
            <div id="logo-container">
                <img id="page-logo" src="../images/logo/holeiconwhite.png" alt="Page logo">
                <p id="page-name">hole</h1>
            </div>
        </a>

        <div id="middle-links">
            <a href="#search-container" id="discover-link">discover</a>
            <a href="./profile.php" id="profile-link">profile</a>
        </div>

        <div id="login-container">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="logout.php" id="logout-link">logout</a>';
            } else {
                echo '<a href="#myModal" id="login-link">login</a>';
            }
            ?>
        </div>

    </div>

    <div id="loginModal" class="logModal">
        <div class="loginModal-content">
            <span class="close">&times;</span>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">login</button>
            </form>
            <p>Don't have an account? <a href="./registration.php">Register here</a>.</p>
        </div>
    </div>


    <div id="search-container">
        <div id="search-about">
            <p>Search for wanted cryptocurrencies bellow. </p>
            <p>Data is collected from CoinGecko API</p>
        </div>

        <div class="search-box-container">
            <input type="text" placeholder="Search..." class="round-search-box">
            <button class="search-button"><img src="../images/search-icon-white.png" alt="Search icon"></button>
        </div>
        <div id="search-results"></div>

    </div>

    <div id="top-list-container">
        <p>Top 100 currencies</p>

        <div id="coins-info">
            <p>#</p>
            <p>coin</p>
            <p>price</p>
            <p>24h</p>
            <p>24h volume</p>
            <p>Mkt Cap</p>
        </div>


    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let coins = [];

            // Fetch coins from the CoinGecko API and store them in the coins array
            async function fetchCoins() {
                try {
                    const response = await fetch('https://api.coingecko.com/api/v3/coins/list');
                    coins = await response.json();
                } catch (error) {
                    console.error("Failed to fetch coins:", error);
                }
            }

            fetchCoins();

            // Regular search function (searches only by coin id)
            function searchCoins(query, list) {
                return list.filter(coin => coin.id.includes(query));
            }

            function searchAndDisplay() {
                const query = document.querySelector(".round-search-box").value;
                if (!query) {
                    return;
                }
                const results = searchCoins(query, coins);
                displayResults(results);
            }

            // Trigger search as the user types
            document.querySelector(".round-search-box").addEventListener("input", searchAndDisplay);

            // Function to display the top 10 search results
            function displayResults(results) {
                const resultsContainer = document.getElementById("search-results");
                resultsContainer.innerHTML = ''; // Clear previous results

                // Show only the first 10 results
                results.slice(0, 10).forEach(coin => {
                    const p = document.createElement("p");
                    p.textContent = `${coin.name} (${coin.symbol}) - ${coin.id}`;
                    p.className = "coin-search-result"
                    p.onclick = function () {
                        showCoinDetails(coin.id);
                    };
                    resultsContainer.appendChild(p);
                });

                function showCoinDetails(coinId) {
                    window.location.href = `./coin.php?id=${coinId}`;
                }
            }

            // Fetch top coins from the CoinGecko API and display them
            async function fetchAndDisplayTopCoins() {
                try {
                    const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=eur&order=market_cap_desc&per_page=100&page=1&sparkline=false&locale=en');
                    const coins = await response.json();
                    displayTopCoins(coins);
                } catch (error) {
                    console.error("Failed to fetch top coins:", error);
                }
            }

            fetchAndDisplayTopCoins();

            function displayTopCoins(coins) {
                const container = document.getElementById("top-list-container");
                coins.forEach((coin, index) => {
                    const coinDiv = document.createElement("div");
                    coinDiv.className = "coin";

                    const priceChangeColor = coin.price_change_percentage_24h < 0 ? 'red' : 'green';
                    const marketCapColor = coin.market_cap_change_percentage < 0 ? 'red' : 'green';

                    coinDiv.innerHTML = `
                <p class="rank">${index + 1}</p>
                <div>
                    <img src="${coin.image}" alt="${coin.name} image">
                    <p>${coin.name}</p>
                </div>
                <div>${new Intl.NumberFormat('en-EN', { style: 'currency', currency: 'EUR' }).format(coin.current_price)}</div>
                <p style="color:${priceChangeColor}">${coin.price_change_percentage_24h.toFixed(2)}%</p>
                <p>${new Intl.NumberFormat('en-EN', { style: 'currency', currency: 'EUR' }).format(coin.total_volume)}</p>
                <p style="color:${marketCapColor}">${new Intl.NumberFormat('en-EN', { style: 'currency', currency: 'EUR' }).format(coin.market_cap)}</p>
            `;

                    container.appendChild(coinDiv);

                    coinDiv.onclick = function () {
                        showCoinDetails(coin.id);
                    };

                });

                function showCoinDetails(coinId) {
                    window.location.href = `./coin.php?id=${coinId}`;
                }


            }
        });

        var modal = document.getElementById("loginModal");
        var btn = document.getElementById("login-link");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>



</body>

</html>