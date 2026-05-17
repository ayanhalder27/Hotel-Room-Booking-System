let allTasks = [];
let currentTaskFilter = "all";

window.onload = function(){
    setTodayDate();
    loadRoomSelect();
    setupTaskFilters();
    loadTodayTasks();

    let createTaskForm = document.getElementById("createTaskForm");
    let updateTaskForm = document.getElementById("updateTaskForm");

    if(createTaskForm){
        createTaskForm.addEventListener("submit", function(e){
            e.preventDefault();
            createTask(this);
        });
    }

    if(updateTaskForm){
        updateTaskForm.addEventListener("submit", function(e){
            e.preventDefault();
            updateTaskFromForm(this);
        });
    }
};

function setTodayDate(){
    let dateInput = document.getElementById("scheduledDate");

    if(dateInput){
        let today = new Date().toISOString().split("T")[0];
        dateInput.value = today;
    }
}

function loadRoomSelect(){
    getData("../../Controler/HousekeepingController/hk_rooms.php?action=room_board", function(data){
        let select = document.getElementById("taskRoomSelect");

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

function setupTaskFilters(){
    let buttons = document.querySelectorAll(".pill");

    for(let i = 0; i < buttons.length; i++){
        buttons[i].addEventListener("click", function(){
            for(let j = 0; j < buttons.length; j++){
                buttons[j].classList.remove("active");
            }

            this.classList.add("active");
            currentTaskFilter = this.getAttribute("data-filter");

            if(currentTaskFilter === "assigned"){
                loadAssignedTasks();
                return;
            }

            if(currentTaskFilter === "all"){
                loadTodayTasks();
                return;
            }

            showTasks();
        });
    }
}

function createTask(form){
    let formData = new FormData(form);
    formData.append("action", "create_task");

    postData("../../Controler/HousekeepingController/hk_tasks.php", formData, function(data){
        if(data.success){
            showMessage("Task created successfully");
            form.reset();
            setTodayDate();
            loadRoomSelect();
            loadTodayTasks();
        }
        else{
            showMessage(data.message);
        }
    });
}

function loadTodayTasks(){
    getData("../../Controler/HousekeepingController/hk_tasks.php?action=tasks_today", function(data){
        if(data.success){
            allTasks = data.rows;
            showTasks();
            checkTaskQueryParam();
        }
        else{
            showMessage(data.message);
        }
    });
}

function loadAssignedTasks(){
    getData("../../Controler/HousekeepingController/hk_tasks.php?action=assigned_tasks", function(data){
        if(data.success){
            allTasks = data.rows;
            showTasks();
            checkTaskQueryParam();
        }
        else{
            showMessage(data.message);
        }
    });
}

function getQueryParam(name){
    let params = new URLSearchParams(window.location.search);
    return params.get(name);
}

function checkTaskQueryParam(){
    let taskId = getQueryParam("task_id");

    if(!taskId){
        return;
    }

    let task = allTasks.find(t => String(t.id) === String(taskId));

    if(task){
        openTaskModal(task.id, task.status, task.notes ?? "");
        return;
    }

    getData("../../Controler/HousekeepingController/hk_tasks.php?action=task_detail&task_id=" + encodeURIComponent(taskId), function(data){
        if(data.success && data.task){
            openTaskModal(data.task.id, data.task.status, data.task.notes ?? "");
        }
    });
}

function showTasks(){
    let output = "";

    if(allTasks.length > 0){
        for(let i = 0; i < allTasks.length; i++){
            let task = allTasks[i];

            if(currentTaskFilter != "all" && currentTaskFilter != "assigned" && currentTaskFilter != "today"){
                if(currentTaskFilter == "urgent" || currentTaskFilter == "normal"){
                    if(task.priority != currentTaskFilter){
                        continue;
                    }
                }
                else if(task.status != currentTaskFilter){
                    continue;
                }
            }

            output += "<tr>";
            output += "<td>" + task.room_number + "</td>";
            output += "<td>" + task.task_type + "</td>";
            output += "<td>" + task.priority + "</td>";
            output += "<td>" + statusText(task.status) + "</td>";
            output += "<td>" + (task.notes ?? "") + "</td>";

            output += "<td>";
            output += "<button type='button' class='table-action' onclick=\"openTaskModal('" + task.id + "', '" + task.status + "', `" + safeText(task.notes) + "`)\">";
            output += "Update";
            output += "</button>";
            output += "</td>";

            output += "</tr>";
        }
    }

    if(output == ""){
        output = "<tr><td colspan='6' class='empty-row'>No tasks found</td></tr>";
    }

    document.getElementById("tasksTable").innerHTML = output;
}

function openTaskModal(taskId, status, notes){
    document.getElementById("modalTaskId").value = taskId;
    document.getElementById("modalTaskStatus").value = status;
    document.getElementById("modalTaskNotes").value = notes;
    document.getElementById("modalRoomStatus").value = "";

    document.getElementById("taskModal").classList.add("show");
}

function updateTaskFromForm(form){
    let formData = new FormData(form);
    formData.append("action", "update_task");

    postData("../../Controler/HousekeepingController/hk_tasks.php", formData, function(data){
        if(data.success){
            showMessage("Task updated successfully");
            closeModal("taskModal");
            form.reset();
            loadRoomSelect();
            loadTodayTasks();
        }
        else{
            showMessage(data.message);
        }
    });
}

function closeModal(id){
    document.getElementById(id).classList.remove("show");
}

function safeText(text){
    if(text == null){
        return "";
    }

    return String(text).replace(/`/g, "");
}
