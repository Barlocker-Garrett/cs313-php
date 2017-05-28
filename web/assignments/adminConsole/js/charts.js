function loaded() {
    var get = {
        "action": "dashboardData"
    };

    $.post('dash.php', get, function (data) {
        console.log(data);
        data = JSON.parse(data);
        if (data.hasOwnProperty("activeGirls") && data.hasOwnProperty("activeGuys") &&
            data.hasOwnProperty("inactiveGirls") && data.hasOwnProperty("inactiveGuys") && 
            data.hasOwnProperty("payingUsers") && data.hasOwnProperty("totalStock") &&
            data.hasOwnProperty("lentOut")) {
            var girls = data["activeGirls"];
            var guys = data["activeGuys"];
            var inactiveGirls = data["inactiveGirls"];
            var inactiveGuys = data["inactiveGuys"];
            var payingUsers = data["payingUsers"];
            var totalStock = data["totalStock"];
            var lentOut = data["lentOut"];
            
            var activeData = {
                labels: [
                "Active Girls",
                "Active Guys",
                "Inactive Girls",
                "Inactive Guys"
            ],
                datasets: [{
                    data: [girls, guys, inactiveGirls, inactiveGuys],
                    backgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#660628",
                    "#0c0666"
                ]
            }]
            };
            var genderActiveCanvas = document.getElementById("genderActiveChart");
            var genderActiveChart = new Chart(genderActiveCanvas, {
                type: 'pie',
                data: activeData,
                options: {
                    title: {
                        display: true,
                        text: 'Active Users By Gender'
                    },
                    legend: {
                        position: 'bottom',
                        reverse: true
                    }
                }
            });

            var data = {
                labels: [
                "Girls",
                "Guys"
            ],
                datasets: [{
                    data: [girls, guys],
                    backgroundColor: [
                    "#FF6384",
                    "#36A2EB"
                ]
            }]
            };
            var genderCanvas = document.getElementById("genderChart");
            var genderChart = new Chart(genderCanvas, {
                type: 'doughnut',
                data: data,
                options: {
                    title: {
                        display: true,
                        text: 'Users By Gender'
                    },
                    legend: {
                        reverse: true,
                        position: 'bottom'
                    }
                }
            });
            
            // Set Number of Active Users Counter
            $({
                countNum: $('#userCounter').text()
            }).animate({
                countNum: girls + guys
            }, {
                duration: 2000,
                easing: 'linear',
                step: function () {
                    $('#userCounter').text(Math.ceil(this.countNum));
                },
                complete: function () {
                    $('#userCounter').text(girls + guys);
                }
            });
            
            // Set Number of Active Paying Users Counter
            $({
                countNum: $('#payingCounter').text()
            }).animate({
                countNum: payingUsers
            }, {
                duration: 2000,
                easing: 'linear',
                step: function () {
                    $('#payingCounter').text(Math.ceil(this.countNum));
                },
                complete: function () {
                    $('#payingCounter').text(payingUsers);
                }
            });
            
            // Set Number of Items in Stock Counter
            $({
                countNum: $('#inventoryCounter').text()
            }).animate({
                countNum: totalStock
            }, {
                duration: 1000,
                easing: 'linear',
                step: function () {
                    $('#inventoryCounter').text(Math.ceil(this.countNum));
                },
                complete: function () {
                    $('#inventoryCounter').text(totalStock);
                }
            });
            
            // Set Number of Lent Out Items
            $({
                countNum: $('#lentOutCounter').text()
            }).animate({
                countNum: lentOut
            }, {
                duration: 2000,
                easing: 'linear',
                step: function () {
                    $('#lentOutCounter').text(Math.ceil(this.countNum));
                },
                complete: function () {
                    $('#lentOutCounter').text(lentOut);
                }
            });
        }
    });
    loadName();
}

function loadName() {
    var session = JSON.parse(sessionStorage.getItem("session"));
    var userId = session["userId"];
    var getName = {
        "action": "getName",
        "userId": userId
    };

    $.post('dash.php', getName, function (data) {
        data = JSON.parse(data);
        if (data.hasOwnProperty("name")) {
            document.getElementById("showName").innerHTML = data["name"] + "!";
        } else {
            document.getElementById("showName").innerHTML = "Unknown";
        }
    });
}