function updateQuantity(element) {
    if (element.value == 0) {
        element.id = element.name;
        removeItem(element);
    } else {
        var updateItem = {
            "product": element.name,
            "action": "add",
            "quantity": element.value
        };

        $.post('session.php', updateItem, function (data) {
            getItems();
            updateTotals(element.name, element.value);
        });
    }
}

function updateTotals(elementName, quantity) {
    if (typeof (document.getElementById("price-" + elementName)) != 'undefined' && document.getElementById("price-" + elementName) != null) {
        var price = parseFloat(document.getElementById("price-" + elementName).innerHTML.substring(1));
    }
    if (typeof (document.getElementById("total-" + elementName)) != 'undefined' && document.getElementById("total-" + elementName) != null) {
        document.getElementById("total-" + elementName).innerHTML = "$" + Number(price * quantity).toFixed(2);
    }
    var elements = document.getElementsByClassName('total');
    var grandTotal = 0;
    for (var i = 0; i < elements.length; i++) {
        grandTotal += parseFloat(elements[i].innerHTML.substring(1));
    }
    document.getElementById("grandTotal").innerHTML = "$" + Number(grandTotal).toFixed(2);
}

function removeItem(element) {
    var remove = {
        "product": element.id,
        "action": "remove"
    };

    $.post('session.php', remove, function (data) {
        deleteItemFromCart(element.id);
        getItems();
        updateTotals(element.name, element.value);
    });

}

function updateEvenOdds(element, even) {
    if (even == null || even == 'undefined') {
        if (element.classList.contains("even")) {
            even = true;
        } else {
            even = false;
        }
    }
    var idx = element.rowIndex;
    if (element) {
        var next = element.parentNode.rows[element.rowIndex + 1];
        if (typeof (next) != 'undefined' && next != null) {
            if (even) {
                next.classList = "item-row even";
                updateEvenOdds(next, false);
            } else {
                next.classList = "item-row odd";
                updateEvenOdds(next, true);
            }
        }
    }
}

function deleteItemFromCart(elementId) {
    var element = document.getElementById("row-" + elementId);
    updateEvenOdds(element);
    document.getElementById("grandTotalRow").style.backgroundColor = "#FFF";
    element.outerHTML = "";
    delete element;
}

function addItem(element) {
    var addItem = {
        "product": element.id,
        "action": "add"
    };

    $.post('session.php', addItem, function (data) {
        getItems();
    });
}

function subtractItem(element) {
    var subtractItem = {
        "product": element.id,
        "action": "subtract"
    };

    $.post('session.php', subtractItem, function (data) {
        getItems();
    });
}

function getItems() {
    var getData = {
        "action": "get"
    };

    $.post('session.php', getData, function (data) {
        var items = JSON.parse(data);
        console.log(items)
        getTotalCount(items);
        return items;
    });
}

function setCount(count) {
    if (count == 0) {
        document.getElementById("numItems").style.display = "none";
        document.getElementById("numItems").innerHTML = count;
    } else {
        document.getElementById("numItems").style.display = "block";
        document.getElementById("numItems").innerHTML = count;
    }
}

function getTotalCount(items) {
    var count = 0;
    var elements = document.getElementsByClassName('subtract')
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.display = "none";
    }
    for (var key in items) {
        var element = document.getElementById(key);
        if (typeof (element) != 'undefined' && element != null) {
            element.style.display = "block";
        }
        if (items.hasOwnProperty(key)) {
            count += Number(items[key]);
        }
    }
    setCount(count);
}