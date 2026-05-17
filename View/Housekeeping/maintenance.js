window.onload = function(){
    loadRoomSelect();
    loadMaintenanceReports();

    let maintenanceForm = document.getElementById("maintenanceForm");
    let updateMaintForm = document.getElementById("updateMaintForm");

    if(maintenanceForm){
        maintenanceForm.addEventListener("submit", function(e){
            e.preventDefault();
            logMaintenance(this);
        });
    }

    if(updateMaintForm){
        updateMaintForm.addEventListener("submit", function(e){
            e.preventDefault();
            updateMaintenance(this);
        });
    }
};

function loadRoomSelect(){
    getData("../../Controller/HousekeepingController/hk_rooms.php?action=room_board", function(data){
        let select = document.getElementById("maintRoomSelect");

        if(!select){
            return;
        }

        let output = "<option value=''>Select room...</option>";

        if(data.success && data.rooms.length > 0){
            for(let i = 0; i < data.rooms.length; i++){
                output += "<option value='" + data.rooms[i].id + "'>";
                output += "Room " + data.rooms[i].room_number + " - " + data.rooms[i].status;
                output += "</option>";
            }
        }

        select.innerHTML = output;
    });
}

function logMaintenance(form){
    let formData = new FormData(form);
    formData.append("action", "log_maintenance");

    postData("../../Controller/HousekeepingController/hk_maintenance.php", formData, function(data){
        if(data.success){
            showMessage("Maintenance issue reported");
            form.reset();
            loadRoomSelect();
            loadMaintenanceReports();
        }
        else{
            showMessage(data.message);
        }
    });
}

function loadMaintenanceReports(){
    getData("../../Controller/HousekeepingController/hk_maintenance.php?action=maintenance_reports", function(data){
        let output = "";

        if(data.success && data.rows.length > 0){
            document.getElementById("openMaintCount").innerHTML = data.rows.length;

            for(let i = 0; i < data.rows.length; i++){
                output += "<tr>";
                output += "<td>" + data.rows[i].room_number + "</td>";
                output += "<td>" + data.rows[i].description + "</td>";
                output += "<td>" + data.rows[i].severity + "</td>";
                output += "<td>" + statusText(data.rows[i].status) + "</td>";
                output += "<td>" + data.rows[i].reported_at + "</td>";

                output += "<td>";
                output += "<button type='button' class='table-action' onclick=\"openMaintenanceModal('" + data.rows[i].id + "', '" + data.rows[i].status + "')\">";
                output += "Update";
                output += "</button>";
                output += "</td>";

                output += "</tr>";
            }
        }
        else{
            document.getElementById("openMaintCount").innerHTML = 0;
            output = "<tr><td colspan='6' class='empty-row'>No maintenance reports found</td></tr>";
        }

        document.getElementById("maintenanceTable").innerHTML = output;
    });
}

function openMaintenanceModal(reportId, status){
    document.getElementById("maintReportId").value = reportId;
    document.getElementById("maintStatus").value = status;
    document.getElementById("maintModal").classList.add("show");
}

function updateMaintenance(form){
    let formData = new FormData(form);
    formData.append("action", "update_maintenance");

    postData("../../Controller/HousekeepingController/hk_maintenance.php", formData, function(data){
        if(data.success){
            showMessage("Maintenance status updated");
            closeModal("maintModal");
            form.reset();
            loadRoomSelect();
            loadMaintenanceReports();
        }
        else{
            showMessage(data.message);
        }
    });
}

function closeModal(id){
    document.getElementById(id).classList.remove("show");
}