window.onload = function(){
    loadRoomFilter();
    loadHistory();

    let roomFilter = document.getElementById("historyRoomFilter");

    if(roomFilter){
        roomFilter.addEventListener("change", function(){
            loadHistory();
        });
    }
};

function loadRoomFilter(){
    getData("../../Controller/HousekeepingController/hk_rooms.php?action=room_board", function(data){
        let roomFilter = document.getElementById("historyRoomFilter");

        if(!roomFilter){
            return;
        }

        let output = "<option value=''>All Rooms</option>";

        if(data.success && data.rooms.length > 0){
            for(let i = 0; i < data.rooms.length; i++){
                output += "<option value='" + data.rooms[i].id + "'>";
                output += "Room " + data.rooms[i].room_number;
                output += "</option>";
            }
        }

        roomFilter.innerHTML = output;
    });
}

function loadHistory(){
    let roomId = "";
    let roomFilter = document.getElementById("historyRoomFilter");

    if(roomFilter){
        roomId = roomFilter.value;
    }

    let url = "../../Controller/HousekeepingController/hk_history.php?action=task_history";

    if(roomId != ""){
        url += "&room_id=" + roomId;
    }

    getData(url, function(data){
        let output = "";

        if(data.success && data.rows.length > 0){
            for(let i = 0; i < data.rows.length; i++){
                output += "<tr>";
                output += "<td>" + data.rows[i].room_number + "</td>";
                output += "<td>" + data.rows[i].task_type + "</td>";
                output += "<td>" + data.rows[i].priority + "</td>";
                output += "<td>" + statusText(data.rows[i].status) + "</td>";
                output += "<td>" + data.rows[i].notes + "</td>";
                output += "<td>" + (data.rows[i].supervisor_name ?? "Supervisor") + "</td>";
                output += "<td>" + (data.rows[i].completed_at ?? "") + "</td>";
                output += "</tr>";
            }
        }
        else{
            output = "<tr><td colspan='7' class='empty-row'>No history found</td></tr>";
        }

        document.getElementById("historyTable").innerHTML = output;
    });
}
