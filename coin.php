<?php
include 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/logo/holeiconwhite.png">
    <title>HoleV2</title>
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/discover.css" />
    <link rel="stylesheet" type="text/css" href="../styles/coin-page.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>

<body>
    <div id="navigation">
        <a href="../index.php">
            <div id="logo-container">
                <img id="page-logo" src="../images/logo/holeiconwhite.png" alt="Page logo">
                <p id="page-name">hole</h1>
            </div>
        </a>
        <div id="middle-links">
            <a href="../index.php" id="discover-link">discover</a>
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

    <div id="title-div">
        <div>
            <h1 id="title"></h1>
        </div>
        <img id="title-logo" src="https://assets.coingecko.com/coins/images/1/large/bitcoin.png?1547033579"
            alt="Coin logo">
    </div>
    <div id="coin-description">
        <p>
        </p>
    </div>

    <form id="add-to-portfolio" action="buy_coin.php" method="post">
        <h2>Add to Portfolio</h2>
        <div class="data-item">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" min="0">
        </div>
        <div class="data-item">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" min="0">
        </div>
        <div>
        <input type="hidden" id="coinId" name="coinId" value="<?php echo $_GET['id']; ?>">
        <button type="submit" id="add-button">Add</button>
        </div>
    </form>




    <section id="market-data">
        <div class="data-item">
            <span class="label">Current Price:</span>
            <span id="current-price" class="value"></span>
        </div>
        <div class="data-item">
            <span class="label">Market Cap:</span>
            <span id="market-cap" class="value"></span>
        </div>
        <div class="data-item">
            <span class="label">Total Volume:</span>
            <span id="total-volume" class="value"></span>
        </div>
        <div class="data-item">
            <span class="label">Circulating Supply:</span>
            <span id="circulating-supply" class="value"></span>
        </div>
    </section>
    <div id="price-chart-container">
        <canvas id="price-chart"></canvas>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const coinId = urlParams.get('id');

            fetch(`https://api.coingecko.com/api/v3/coins/${coinId}?localization=false`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("title-logo").src = data.image.large;
                    document.getElementById("title").textContent = data.name;
                    document.getElementById("coin-description").innerHTML = data.description.en;
                    document.getElementById("current-price").textContent = `$${data.market_data.current_price.eur.toFixed(2)} EUR`;
                    document.getElementById("market-cap").textContent = `$${data.market_data.market_cap.eur.toLocaleString()} EUR`;
                    document.getElementById("total-volume").textContent = `$${data.market_data.total_volume.eur.toLocaleString()} EUR`;
                    document.getElementById("circulating-supply").textContent = `${data.market_data.circulating_supply.toLocaleString()} ${data.symbol.toUpperCase()}`;
                    const priceChange = data.market_data.price_change_percentage_24h;
                    const marketCapChange = data.market_data.market_cap_change_percentage_24h;
                    document.getElementById("current-price").textContent = `$${data.market_data.current_price.eur.toFixed(2)} EUR`;
                    document.getElementById("current-price").style.color = priceChange < 0 ? 'red' : 'green';
                    document.getElementById("market-cap").textContent = `$${data.market_data.market_cap.eur.toLocaleString()} EUR`;
                    document.getElementById("market-cap").style.color = marketCapChange < 0 ? 'red' : 'green';

                    fetch(`https://api.coingecko.com/api/v3/coins/${coinId}/market_chart?vs_currency=eur&days=365&interval=daily`)
                        .then(response => response.json())
                        .then(data => {
                            const ctx = document.getElementById('price-chart').getContext('2d');
                            const priceChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: data.prices.map(price => new Date(price[0])),
                                    datasets: [{
                                        label: 'Price (EUR)',
                                        data: data.prices.map(price => price[1]),
                                        borderColor: 'white',
                                        backgroundColor: 'rgba(75, 75, 75, 0.2)',
                                        fill: true,
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            labels: {
                                                color: 'white',
                                                font: {
                                                    family: 'monospace',
                                                    size: 16,
                                                },
                                            },
                                        },
                                    },
                                    scales: {
                                        x: {
                                            type: 'time',
                                            time: {
                                                unit: 'month',
                                                displayFormats: {
                                                    month: 'MMM yyyy'
                                                }
                                            },
                                            ticks: {
                                                color: 'grey',
                                                font: {
                                                    family: 'monospace',
                                                    size: 14,
                                                    style: 'normal',
                                                },
                                            },
                                            grid: {
                                                color: 'grey',
                                            },
                                        },
                                        y: {
                                            beginAtZero: false,
                                            ticks: {
                                                color: 'grey',
                                                font: {
                                                    family: 'monospace',
                                                    size: 14,
                                                    style: 'normal',
                                                },
                                            },
                                            grid: {
                                                color: 'grey',
                                            },
                                        }
                                    },
                                    layout: {
                                        padding: {
                                            left: 10,
                                            right: 10,
                                            top: 10,
                                            bottom: 10
                                        }
                                    },
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    backgroundColor: 'black'
                                }
                            });
                        })
                        .catch(error => {
                            console.error("There was an error fetching the market chart data", error);
                        });
                })
                .catch(error => {
                    console.error("There was an error fetching coin details", error);
                });
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