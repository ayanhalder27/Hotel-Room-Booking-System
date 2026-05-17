window.onload = function(){
    loadSchedule();
};

function loadSchedule(){
    getData("../../Controller/HousekeepingController/hk_schedule.php?action=schedule", function(data){
        if(data.success){
            showTodayCheckouts(data.today_checkouts);
            showTomorrowCheckouts(data.tomorrow_checkouts);
            showUpcomingCheckins(data.upcoming_checkins);
        }
        else{
            showMessage(data.message);
        }
    });
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