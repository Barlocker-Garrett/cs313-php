function updateTable() {

    var update = {
        "action": "users",
        "filter": false,
        "orderBy": false
    };

    update = getFilters(update);
    update = getOrderBy(update);

    $.post('users.php', update, function (newTable) {
        $("#userTable").empty().append(newTable);
        $(function () {
            $(".td-value").dblclick(function (e) {
                e.stopPropagation();
                var currentEle = $(this);
                var value = $(this).html();
                var element = currentEle.siblings(":last").children(":first");
                element.removeClass("saveButton");
                updateVal(currentEle, value);
            });
        });
    });
}

function getFilters(update) {
    var filterAdded = false;
    var filters = document.getElementById("form-filters");
    var filterObject = formToJSON(filters);
    if (filterObject.hasOwnProperty("Gender")) {
        update['ismale'] = filterObject["GenderSelect"];
        filterAdded = true;
    }
    if (document.getElementById("LentOut").checked) {
        var lentOutId = $('#LentOutSelect').val();
        update['lentout'] = lentOutId;
        filterAdded = true;
    }
    if (filterObject.hasOwnProperty("FullName")) {
        if (filterObject["fullName"] != undefined) {
            update['fullname'] = filterObject["fullName"];
            filterAdded = true;
        }
    }
    if (document.getElementById("Gender").checked ||
        document.getElementById("LentOut").checked ||
        document.getElementById("FullName").checked &&
        filterAdded) {
        update['filter'] = true;
    }
    return update;
}

function getOrderBy(update) {
    var orderByAdded = false;
    if (document.getElementById("OrderByUserID").checked) {
        update['orderUserId'] = true;
    }
    if (document.getElementById("OrderByFullName").checked) {
        update['orderFullName'] = true;
    }
    if (document.getElementById("OrderByGender").checked) {
        update['orderGender'] = true;
    }
    if (document.getElementById("OrderByHeight").checked) {
        update['orderHeight'] = true;
    }
    if (document.getElementById("OrderByWeight").checked) {
        update['orderWeight'] = true;
    }

    if (document.getElementById("OrderByUserID").checked ||
        document.getElementById("OrderByFullName").checked ||
        document.getElementById("OrderByGender").checked ||
        document.getElementById("OrderByHeight").checked ||
        document.getElementById("OrderByWeight").checked) {
        update['orderBy'] = true;
    }
    return update;
}

function saveSession() {
    var params = {};
    var getParams = window.location.search.substring(1);
    var vars = getParams.split("&");
    for (var i = 0; i < vars.length; i++) {
        var keyValuePair = vars[i].split("=");
        if (typeof params[keyValuePair[0]] === "undefined") {
            params[keyValuePair[0]] = decodeURIComponent(keyValuePair[1]);
        } else if (typeof params[keyValuePair[0]] === "string") {
            var arr = [params[keyValuePair[0]], decodeURIComponent(keyValuePair[1])];
            params[keyValuePair[0]] = arr;
        } else {
            params[keyValuePair[0]].push(decodeURIComponent(keyValuePair[1]));
        }
    }
    storeSession(params);
    jsMaterialize();
}

function storeSession(params) {
    if (params.hasOwnProperty("userId") && params.hasOwnProperty("token")) {
        if (typeof (sessionStorage) !== "undefined") {
            sessionStorage.setItem("session", JSON.stringify(params));
        } else {
            // Session Storage not Supported
        }
    }
}

function jsMaterialize() {
    $(document).ready(function () {
        $('select').material_select();
    });
}

function updateUser(User) {
    var update = {
        "action": "updateUser",
        "user": User
    };

    console.log(update);

    $.post('users.php', update, function (data) {
        console.log(data);
        var element = $("#save" + User['id']).children(":first");
        element.addClass("saveButton");
    });
}

function deleteUser(User) {
    var remove = {
        "action": "deleteUser",
        "user": User
    };

    console.log(remove);

    $.post('users.php', remove, function (data) {
        console.log(data);
        updateTable();
    });
}

function saveUser(userId) {
    if (typeof userId == 'number') {
        var User = {};
        User['id'] = userId;
        User['ismale'] = document.getElementById('isMale' + userId).innerHTML;
        User['fullname'] = document.getElementById('fullName' + userId).innerHTML;
        User['birthdate'] = document.getElementById('birthdate' + userId).innerHTML;
        User['height'] = document.getElementById('height' + userId).innerHTML;
        User['weight'] = document.getElementById('weight' + userId).innerHTML;
        var phoneNumber = document.getElementById('phoneNumber' + userId).innerHTML;
        User['phonenumber'] = phoneNumber.replace(/[^0-9]/g, '');
        User['email'] = document.getElementById('email' + userId).innerHTML;
        User['address'] = document.getElementById('address' + userId).innerHTML;
        User['apt'] = document.getElementById('apt' + userId).innerHTML;
        User['city'] = document.getElementById('city' + userId).innerHTML;
        User['state'] = document.getElementById('state' + userId).innerHTML;
        updateUser(User);
    }
}

function removeUser(userId) {
    if (typeof userId == 'number') {
        var User = {};
        User['id'] = userId;
        deleteUser(User);
    }
}

function createUser() {
    if ($(".wrapper").length == 0) {
        $("#createUserForm").wrapInner("<div class='wrapper'></div>");
    }
    $("#createUserForm").show();
    $("#createUserForm").click(function (e) {
        if (e.target == this) {
            if ($("#createUserForm").is(":visible")) {
                $("#createUserForm").hide();
            }
        }
    });
}

function insertNewUser(User) {
    var insert = {
        "action": "insertUser",
        "user": User
    };

    console.log(insert);

    $.post('users.php', insert, function (data) {
        console.log(data);insert
        $("#createUserForm").hide();
        clearNewUserForm();
        updateTable();
        
    });
}

function clearNewUserForm() {
    document.getElementById('fullnameCreate').value = "";
    document.getElementById('birthdateCreate').value = "";
    document.getElementById('heightCreate').value = "";
    document.getElementById('weightCreate').value = "";
    document.getElementById('phonenumberCreate').value = "";
    document.getElementById('emailCreate').value = "";
    document.getElementById('passwordCreate').value = "";
    document.getElementById('addressCreate').value = "";
    document.getElementById('aptCreate').value = "";
    document.getElementById('cityCreate').value = "";
    document.getElementById('stateCreate').value = "";
}

function createNewUser() {
    var User = {};
    User['ismale'] = document.getElementById('genderCreate').value;
    User['fullname'] = document.getElementById('fullnameCreate').value;
    User['birthdate'] = document.getElementById('birthdateCreate').value;
    User['height'] = document.getElementById('heightCreate').value;
    User['weight'] = document.getElementById('weightCreate').value;
    var phoneNumber = document.getElementById('phonenumberCreate').value;
    User['phonenumber'] = phoneNumber.replace(/[^0-9]/g, '');
    User['email'] = document.getElementById('emailCreate').value;
    User['password'] = document.getElementById('passwordCreate').value;
    User['address'] = document.getElementById('addressCreate').value;
    User['apt'] = document.getElementById('aptCreate').value;
    User['city'] = document.getElementById('cityCreate').value;
    User['state'] = document.getElementById('stateCreate').value;
    insertNewUser(User);
}

function saveItem(itemId) {
    if (typeof itemId == 'number') {
        var Item = {};
        Item['id'] = itemId;
        Item['itemName'] = document.getElementById('itemName' + itemId).innerHTML;
        Item['stock'] = document.getElementById('stock' + itemId).innerHTML;
        Item['lentOut'] = document.getElementById('lentout' + itemId).innerHTML;
        var price =  document.getElementById('price' + itemId).innerHTML;
        Item['price'] = price.replace(/[^0-9.]/g, '');
        var replacePrice = document.getElementById('replacePrice' + itemId).innerHTML;
        Item['replacePrice'] = replacePrice.replace(/[^0-9.]/g, '');
        updateItem(Item);
    }
}

function updateItem(Item) {
    var update = {
        "action": "updateItem",
        "item": Item
    };

    console.log(update);

    $.post('item.php', update, function (data) {
        console.log(data);
        var element = $("#save" + Item['id']).children(":first");
        element.addClass("saveButton");
    });
}

function removeItem(itemId) {
    if (typeof itemId == 'number') {
        var Item = {};
        Item['id'] = itemId;
        deleteItem(Item);
    }
}

function deleteItem(Item) {
    var remove = {
        "action": "deleteItem",
        "item": Item
    };

    console.log(remove);

    $.post('item.php', remove, function (data) {
        console.log(data);
        updateInventory()
    });
}

function createItem() {
    if ($(".wrapper").length == 0) {
        $("#createItemForm").wrapInner("<div class='wrapper'></div>");
    }
    $("#createItemForm").show();
    $("#createItemForm").click(function (e) {
        if (e.target == this) {
            if ($("#createItemForm").is(":visible")) {
                $("#createItemForm").hide();
            }
        }
    });
}

function createNewItem() {
    var Item = {};
    Item['itemName'] = document.getElementById('itemNameCreate').value;
    Item['stock'] = document.getElementById('stockCreate').value;
    Item['lentout'] = document.getElementById('lentoutCreate').value;
    Item['price'] = document.getElementById('priceCreate').value.replace(/[^0-9.]/g, '');
    Item['replacePrice'] = document.getElementById('replacePriceCreate').value.replace(/[^0-9.]/g, '');
    insertNewItem(Item);
}

function insertNewItem(Item) {
    var insert = {
        "action": "insertItem",
        "item": Item
    };
    console.log(insert);
    $.post('item.php', insert, function (data) {
        console.log(data);insert
        $("#createItemForm").hide();
        clearNewItemForm();
        updateInventory();
    });
}

function clearNewItemForm() {
    document.getElementById('itemNameCreate').value = "";
    document.getElementById('stockCreate').value = "";
    document.getElementById('lentoutCreate').value = "";
    document.getElementById('priceCreate').value = "";
    document.getElementById('replacePriceCreate').value = "";
}

function updateInventory() {

    var update = {
        "action": "updateItemTable"
    };

    $.post('item.php', update, function (newTable) {
        console.log(newTable);
        $("#userTable").empty().append(newTable);
        $(function () {
            $(".td-value").dblclick(function (e) {
                e.stopPropagation();
                var currentEle = $(this);
                var value = $(this).html();
                var element = currentEle.siblings(":last").children(":first");
                element.removeClass("saveButton");
                updateVal(currentEle, value);
            });
        });
    });
}


// START SWAP TD FOR INPUT FIELD
$(function () {
    $(".td-value").dblclick(function (e) {
        e.stopPropagation();
        var currentEle = $(this);
        var value = $(this).html();
        currentEle.siblings(":last").children(":first").removeClass("saveButton");
        updateVal(currentEle, value);
    });
});

function updateVal(currentEle, value) {
    $(document).off('click');
    $(currentEle).html('<input class="td-input thVal " type="text" value="' + value + '" />');
    $(".thVal").focus();
    $(".thVal").keyup(function (event) {
        if (event.keyCode == 13) {
            $(currentEle).html($(".thVal").val());
        }
    });

    $(document).click(function () {
        $(currentEle).html($(".thVal").val());
    });
}
// END SWAP TD FOR INPUT FIELD