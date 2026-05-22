window.onload = function(){
    loadDashboardStats();
    loadTodayCheckouts();
    loadUpcomingCheckins();
    loadUrgentTasks();
};

function loadDashboardStats(){
    getData("../../Controler/HousekeepingController/hk_dashboard.php?action=dashboard_stats", function(data){
        if(data.success){
            document.getElementById("statDirty").innerHTML = data.dirty;
            document.getElementById("statInspection").innerHTML = data.inspection;
            document.getElementById("statMaintenance").innerHTML = data.maintenance;
            document.getElementById("statDone").innerHTML = data.done_today;
        }
        else{
            showMessage(data.message);
        }
    });
}

function loadTodayCheckouts(){
    getData("../../Controler/HousekeepingController/hk_dashboard.php?action=today_checkouts", function(data){
        let output = "";

        if(data.success && data.rows.length > 0){
            document.getElementById("coCount").innerHTML = data.rows.length;

            for(let i = 0; i < data.rows.length; i++){
                output += "<tr>";
                output += "<td>" + data.rows[i].room_number + "</td>";
                output += "<td>" + data.rows[i].guest_name + "</td>";
                output += "<td>" + data.rows[i].checkout_date + "</td>";
                output += "<td>Normal</td>";
                output += "</tr>";
            }
        }
        else{
            document.getElementById("coCount").innerHTML = 0;

            output += "<tr>";
            output += "<td colspan='4' class='empty-row'>No check-outs today</td>";
            output += "</tr>";
        }

        document.getElementById("checkoutTable").innerHTML = output;
    });
}

function loadUpcomingCheckins(){
    getData("../../Controler/HousekeepingController/hk_dashboard.php?action=upcoming_checkins", function(data){
        let output = "";

        if(data.success && data.rows.length > 0){
            document.getElementById("ciCount").innerHTML = data.rows.length;

            for(let i = 0; i < data.rows.length; i++){
                output += "<tr>";
                output += "<td>" + data.rows[i].room_number + "</td>";
                output += "<td>" + data.rows[i].guest_name + "</td>";
                output += "<td>" + data.rows[i].checkin_date + "</td>";
                output += "<td>" + data.rows[i].room_status + "</td>";
                output += "</tr>";
            }
        }
        else{
            document.getElementById("ciCount").innerHTML = 0;

            output += "<tr>";
            output += "<td colspan='4' class='empty-row'>No upcoming check-ins</td>";
            output += "</tr>";
        }

        document.getElementById("checkinTable").innerHTML = output;
    });
}

function loadUrgentTasks(){
    getData("../../Controler/HousekeepingController/hk_dashboard.php?action=urgent_tasks", function(data){
        let output = "";

        if(data.success && data.rows.length > 0){
            document.getElementById("urgentCount").innerHTML = data.rows.length;

            for(let i = 0; i < data.rows.length; i++){
                if(data.rows[i].priority && data.rows[i].priority.toLowerCase().trim() !== 'urgent'){
                    continue;
                }

                output += "<tr>";
                output += "<td>" + data.rows[i].room_number + "</td>";
                output += "<td>" + data.rows[i].task_type + "</td>";
                output += "<td>" + data.rows[i].notes + "</td>";
                output += "<td>" + data.rows[i].scheduled_date + "</td>";
                output += "<td>" + statusText(data.rows[i].status) + "</td>";

                // 6th column: Action
                output += "<td>";
                output += "<button type='button' class='table-action' onclick=\"openUrgentTaskModal('" + data.rows[i].id + "', '" + data.rows[i].status + "', `" + safeText(data.rows[i].notes) + "`)\">Update</button>";
                output += "</td>";

                output += "</tr>";
            }
        }
        else{
            document.getElementById("urgentCount").innerHTML = 0;

            output += "<tr>";
            output += "<td colspan='6' class='empty-row'>No urgent tasks</td>";
            output += "</tr>";
        }

        document.getElementById("urgentTasksTable").innerHTML = output;
    });
}

function openUrgentTaskModal(taskId, status, notes){
    document.getElementById("urgentModalTaskId").value = taskId;
    document.getElementById("urgentModalTaskStatus").value = status;
    document.getElementById("urgentModalTaskNotes").value = notes || "";
    document.getElementById("urgentModalRoomStatus").value = "";
    document.getElementById("urgentTaskModal").classList.add("show");
}

function safeText(text){
    if(text == null){
        return "";
    }

    return String(text).replace(/`/g, "");
}

let urgentTaskUpdateForm = document.getElementById("urgentTaskUpdateForm");

if(urgentTaskUpdateForm){
    urgentTaskUpdateForm.addEventListener("submit", function(e){
        e.preventDefault();
        updateUrgentTask(this);
    });
}

function updateUrgentTask(form){
    let formData = new FormData(form);
    formData.append("action", "update_task");

    postData("../../Controler/HousekeepingController/hk_tasks.php", formData, function(data){
        if(data.success){
            showMessage("Task updated successfully");
            closeModal("urgentTaskModal");
            loadUrgentTasks();
            loadDashboardStats();
            loadTodayCheckouts();
            loadUpcomingCheckins();
        }
        else{
            showMessage(data.message);
        }
    });
}
