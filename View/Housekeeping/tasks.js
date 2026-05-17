let allTasks = [];
let currentTaskFilter = "all";

window.onload = function(){
    setTodayDate();
    loadRoomSelect();
    loadTodayTasks();
    setupTaskFilters();

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
    getData("../../Controller/HousekeepingController/hk_rooms.php?action=room_board", function(data){
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

            showTasks();
        });
    }
}

function createTask(form){
    let formData = new FormData(form);
    formData.append("action", "create_task");

    postData("../../Controller/HousekeepingController/hk_tasks.php", formData, function(data){
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
    getData("../../Controller/HousekeepingController/hk_tasks.php?action=tasks_today", function(data){
        if(data.success){
            allTasks = data.rows;
            showTasks();
        }
        else{
            showMessage(data.message);
        }
    });
}

function showTasks(){
    let output = "";

    if(allTasks.length > 0){
        for(let i = 0; i < allTasks.length; i++){
            let task = allTasks[i];

            if(currentTaskFilter != "all"){
                if((currentTaskFilter == "urgent" || currentTaskFilter == "normal") && task.priority != currentTaskFilter){
                    continue;
                }

                if(currentTaskFilter != "urgent" && currentTaskFilter != "normal" && task.status != currentTaskFilter){
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

    postData("../../Controller/HousekeepingController/hk_tasks.php", formData, function(data){
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
