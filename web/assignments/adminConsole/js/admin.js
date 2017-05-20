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
                var id = $(this).siblings(":last").children(":first").removeClass("saveButton");
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

// START SWAP TD FOR INPUT FIELD
$(function () {
    $(".td-value").dblclick(function (e) {
        e.stopPropagation();
        var currentEle = $(this);
        var value = $(this).html();
        var id = $(this).siblings(":last").children(":first").removeClass("saveButton");
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