window.onload = function(){
    showReportDate();
    loadDailyReport();
};

function showReportDate(){
    let reportDate = document.getElementById("reportDate");

    if(reportDate){
        let today = new Date();
        reportDate.innerHTML = today.toLocaleDateString();
    }
}

function loadDailyReport(){
    getData("../Controler/hk_report.php?action=daily_report", function(data){
        if(data.success){
            document.getElementById("rTotalTasks").innerHTML = data.total;
            document.getElementById("rCompleted").innerHTML = data.done;
            document.getElementById("rPending").innerHTML = data.pending;
            document.getElementById("rReadyRooms").innerHTML = data.ready;

            let output = "";

            if(data.rows.length > 0){
                for(let i = 0; i < data.rows.length; i++){
                    output += "<tr>";
                    output += "<td>" + data.rows[i].room_number + "</td>";
                    output += "<td>" + data.rows[i].task_type + "</td>";
                    output += "<td>" + data.rows[i].priority + "</td>";
                    output += "<td>" + statusText(data.rows[i].status) + "</td>";
                    output += "<td>" + (data.rows[i].completed_at ?? "") + "</td>";
                    output += "<td>" + data.rows[i].notes + "</td>";
                    output += "</tr>";
                }
            }
            else{
                output = "<tr><td colspan='6' class='empty-row'>No report data found</td></tr>";
            }

            document.getElementById("reportTable").innerHTML = output;
        }
        else{
            showMessage(data.message);
        }
    });
}