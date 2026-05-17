let cleaningPriorityRows = [];

window.onload = function(){
    loadSchedule();

    let prioritySearch = document.getElementById("prioritySearch");

    if(prioritySearch){
        prioritySearch.addEventListener("input", function(){
            showCleaningPriority(cleaningPriorityRows);
        });
    }
};

function loadSchedule(){
    getData("../../Controller/HousekeepingController/hk_schedule.php?action=schedule", function(data){
        if(data.success){
            cleaningPriorityRows = data.cleaning_priority;
            showCleaningPriority(cleaningPriorityRows);
            showTodayCheckouts(data.today_checkouts);
            showTomorrowCheckouts(data.tomorrow_checkouts);
            showUpcomingCheckins(data.upcoming_checkins);
        }
        else{
            showMessage(data.message);
        }
    });
}

function showCleaningPriority(rows){
    let output = "";
    let search = "";
    let rank = 1;

    let prioritySearch = document.getElementById("prioritySearch");

    if(prioritySearch){
        search = prioritySearch.value.trim().toLowerCase();
    }

    if(rows.length > 0){
        for(let i = 0; i < rows.length; i++){
            let roomNumber = rows[i].room_number ?? "";
            let guestName = rows[i].guest_name ?? "";
            let checkoutDay = rows[i].checkout_day ?? "";
            let searchable = (roomNumber + " " + guestName + " " + checkoutDay).toLowerCase();

            if(search != "" && searchable.indexOf(search) == -1){
                continue;
            }

            output += "<tr>";
            output += "<td><span class='priority-rank'>" + rank + "</span></td>";
            output += "<td>" + roomNumber + "</td>";
            output += "<td>" + guestName + "</td>";
            output += "<td>" + rows[i].checkout_date + "</td>";
            output += "<td>" + checkoutDay + "</td>";
            output += "<td>" + statusText(rows[i].room_status) + "</td>";
            output += "</tr>";

            rank++;
        }
    }

    if(output == ""){
        output = "<tr><td colspan='6' class='empty-row'>No check-outs today or tomorrow</td></tr>";
    }

    document.getElementById("cleaningPriorityTable").innerHTML = output;
}

function showTodayCheckouts(rows){
    let output = "";

    if(rows.length > 0){
        for(let i = 0; i < rows.length; i++){
            output += "<tr>";
            output += "<td>" + rows[i].room_number + "</td>";
            output += "<td>" + rows[i].guest_name + "</td>";
            output += "<td>" + rows[i].checkout_date + "</td>";
            output += "<td>" + statusText(rows[i].room_status) + "</td>";
            output += "</tr>";
        }
    }
    else{
        output = "<tr><td colspan='4' class='empty-row'>No check-outs today</td></tr>";
    }

    document.getElementById("scheduleCheckoutTable").innerHTML = output;
}

function showTomorrowCheckouts(rows){
    let output = "";

    if(rows.length > 0){
        for(let i = 0; i < rows.length; i++){
            output += "<tr>";
            output += "<td>" + rows[i].room_number + "</td>";
            output += "<td>" + rows[i].guest_name + "</td>";
            output += "<td>" + rows[i].checkout_date + "</td>";
            output += "<td>" + statusText(rows[i].room_status) + "</td>";
            output += "</tr>";
        }
    }
    else{
        output = "<tr><td colspan='4' class='empty-row'>No check-outs tomorrow</td></tr>";
    }

    document.getElementById("scheduleTomorrowTable").innerHTML = output;
}

function showUpcomingCheckins(rows){
    let output = "";

    if(rows.length > 0){
        for(let i = 0; i < rows.length; i++){
            let ready = "No";

            if(rows[i].room_status == "available"){
                ready = "Yes";
            }

            output += "<tr>";
            output += "<td>" + rows[i].room_number + "</td>";
            output += "<td>" + rows[i].guest_name + "</td>";
            output += "<td>" + rows[i].checkin_date + "</td>";
            output += "<td>" + statusText(rows[i].room_status) + "</td>";
            output += "<td>" + ready + "</td>";
            output += "</tr>";
        }
    }
    else{
        output = "<tr><td colspan='5' class='empty-row'>No upcoming check-ins</td></tr>";
    }

    document.getElementById("scheduleCheckinTable").innerHTML = output;
}
