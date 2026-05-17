let allRooms = [];
let currentFilter = "all";

window.onload = function(){
    loadRoomStatus();
    setupRoomFilters();

    // Auto refresh every 30 seconds
    setInterval(function(){
        loadRoomStatus();
    }, 30000);
};

function setupRoomFilters(){
    let buttons = document.querySelectorAll(".filter-btn");

    for(let i = 0; i < buttons.length; i++){
        buttons[i].addEventListener("click", function(){
            for(let j = 0; j < buttons.length; j++){
                buttons[j].classList.remove("active");
            }

            this.classList.add("active");
            currentFilter = this.getAttribute("data-filter");

            showRooms();
        });
    }
}

function loadRoomStatus(){
    getData("../../Controller/HousekeepingController/hk_rooms.php?action=room_board", function(data){
        if(data.success){
            allRooms = data.rooms;
            showRooms();
        }
        else{
            showMessage(data.message);
        }
    });
}

function showRooms(){
    let roomGrid = document.getElementById("roomGrid");
    let output = "";
    let found = false;

    if(!roomGrid){
        return;
    }

    if(allRooms.length == 0){
        roomGrid.innerHTML = "<div class='empty-row'>No room data found</div>";
        return;
    }

    for(let i = 0; i < allRooms.length; i++){
        let room = allRooms[i];

        if(currentFilter != "all" && room.status != currentFilter){
            continue;
        }

        found = true;

        output += "<div class='room-card " + getRoomStatusClass(room.status) + "'>";
        output += "<div class='room-card-top'>";
        output += "<h3>Room " + room.room_number + "</h3>";
        output += "<span class='room-status'>" + statusText(room.status) + "</span>";
        output += "</div>";

        output += "<div class='room-info'>";
        output += "<p><b>Room ID:</b> " + room.id + "</p>";
        output += "<p><b>Floor:</b> " + room.floor + "</p>";
        output += "<p><b>Type:</b> " + (room.type_name ?? "N/A") + "</p>";
        output += "</div>";
        output += "</div>";
    }

    if(!found){
        output = "<div class='empty-row'>No rooms found for this filter</div>";
    }

    roomGrid.innerHTML = output;
}

function getRoomStatusClass(status){
    if(status == "available"){
        return "room-available";
    }

    if(status == "dirty"){
        return "room-dirty";
    }

    if(status == "maintenance"){
        return "room-maintenance";
    }

    if(status == "occupied"){
        return "room-occupied";
    }

    if(status == "blocked"){
        return "room-blocked";
    }

    return "";
}