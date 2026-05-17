function getData(url, callback){
    let xhr = new XMLHttpRequest();

    let cacheBuster = "_=" + Date.now();
    url += (url.indexOf("?") === -1 ? "?" : "&") + cacheBuster;

    xhr.open("GET", url, true);

    xhr.onload = function(){
        if(this.status == 403){
            window.location.href = "../../View/login.html";
            return;
        }

        if(this.status == 200){
            try{
                let data = JSON.parse(this.responseText);
                callback(data);
            }
            catch(error){
                alert("Invalid server response");
                console.log(this.responseText);
            }
        }
        else{
            alert("Server error or unauthorized");
        }
    };

    xhr.send();
}

function postData(url, formData, callback){
    let xhr = new XMLHttpRequest();

    xhr.open("POST", url, true);

    xhr.onload = function(){
        if(this.status == 403){
            window.location.href = "../../View/login.html";
            return;
        }

        if(this.status == 200){
            try{
                let data = JSON.parse(this.responseText);
                callback(data);
            }
            catch(error){
                alert("Invalid server response");
                console.log(this.responseText);
            }
        }
        else{
            alert("Server error or unauthorized");
        }
    };

    xhr.send(formData);
}

function showMessage(message){
    alert(message);
}

function statusText(status){
    if(status == "in_progress"){
        return "In Progress";
    }

    if(status == "done"){
        return "Done";
    }

    if(status == "pending"){
        return "Pending";
    }

    if(status == "open"){
        return "Open";
    }

    if(status == "resolved"){
        return "Resolved";
    }

    if(status == "available"){
        return "Available";
    }

    if(status == "occupied"){
        return "Occupied";
    }

    if(status == "dirty"){
        return "Dirty";
    }

    if(status == "maintenance"){
        return "Maintenance";
    }

    if(status == "blocked"){
        return "Blocked";
    }

    return status;
}

function toggleSidebar(){
    let sidebar = document.getElementById("sidebar");

    if(sidebar){
        sidebar.classList.toggle("show");
    }
}

function closeModal(id){
    let modal = document.getElementById(id);

    if(modal){
        modal.classList.remove("show");
    }
}

function showTopbarDate(){
    let topbarDate = document.getElementById("topbarDate");

    if(topbarDate){
        let today = new Date();
        topbarDate.innerHTML = "Date: " + today.toLocaleDateString();
    }
}

function setActiveSidebar(){
    let currentPage = window.location.pathname.split("/").pop();
    let navItems = document.querySelectorAll(".sidebar-nav .nav-item");

    for(let i = 0; i < navItems.length; i++){
        navItems[i].classList.remove("active");

        let linkPage = navItems[i].getAttribute("href");

        if(linkPage == currentPage){
            navItems[i].classList.add("active");
        }
    }
}

document.addEventListener("DOMContentLoaded", function(){
    showTopbarDate();
    setActiveSidebar();
});
