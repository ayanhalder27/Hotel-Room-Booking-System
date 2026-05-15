function getData(url, callback){
    let xhr = new XMLHttpRequest();

    xhr.open("GET", url, true);

    xhr.onload = function(){
        if(this.status == 200){
            let data = JSON.parse(this.responseText);
            callback(data);
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
        if(this.status == 200){
            let data = JSON.parse(this.responseText);
            callback(data);
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

    return status;
}